/**
 * Simple PHP IRC Logger
 *
 * PHP Version 5
 *
 * @category   Chat Room Scipt
 * @package    Simple PHP IRC Logger
 * heavy mods and based on the following: http://wildphp.com
 */

//So the bot doesn't stop.
set_time_limit(0);
ini_set('display_errors', 'on');

/* --- Varibles and Config Info --- */

//Sample connection data.
$config = array(
        //General Config Info
        'server' => 'localhost',
        'port'   => 6667,
        'name'   => 'logger',
        'nick'   => 'logger',
        'pass'   => '',

        //Logging Config Info
        'channel' => '#slopwiki',
        'logging' => true,
    'warning' => true,
);


/*
//Set your connection data.
$config = array(
        //General Config Info
        'server' => 'irc.example.com',
        'port'   => 6667,
        'name'   => 'real name',
        'nick'   => 'user',
        'pass'   => 'pass',

        //Logging Config Info
        'channel' => '#channel',
        'logging' => true,
        'warning' => true,
);
*/

/* --- IRCBot Class --- */

class IRCBot {

        //This is going to hold our TCP/IP connection
        var $socket;

        //This is going to hold all of the messages both server and client
        var $ex = array();
        //var $logging = true;

        /*
         Construct item, opens the server connection, logs the bot in
         @param array
        */

        function __construct($config)
        {
                $this->socket = fsockopen($config['server'], $config['port']);
                $this->login($config);
                $this->main($config);
        }

        /*
         Logs the bot in on the server
         @param array
        */

        function login($config)
        {
                $this->send_data('USER', $config['nick'].' logger '.$config['nick'].' :'.$config['name']);
                $this->send_data('NICK', $config['nick']);
                $this->join_channel($config['channel']);

                 if($config['logging']) {
                        $date = date("y-n-j");
            $time = date('h:i:s A');
                        $logfile = fopen("$date-log.html","a");
                        fwrite($logfile,"
**************** Logging Started at $date - $time ****************
");
                        fclose($logfile);

                        //Warn that logging has been enabled
                         if($config['warning']) {
                                   $this->send_data('PRIVMSG '.$config['channel'].' :', "Chat Logging has been [Enabled]");
                           }
                 }
        }

        /*
         This is the workhorse function, grabs the data from the server and displays on the browser
        */

        function main($config)
        {
                $data = fgets($this->socket, 256);

                echo nl2br($data);

                flush();

                $this->ex = explode(' ', $data);

                if($this->ex[0] == 'PING')
                {
                        $this->send_data('PONG', $this->ex[0]); //Plays ping-pong with the server to stay connected.
                }

                 //Logs the chat
                if($config['logging'])
                {
                    $logtxt = $this->filter_log($this->ex[1], $this->ex[2], $this->ex[0], $this->get_msg($this->ex)); //Gets human readable text from irc data
                    if($logtxt != null) { //Writes to log if it is a message
                        $date = date("y-n-j");
                $logfile = fopen("$date-log.html","a");
                        fwrite($logfile,"$logtxt");
                        fclose($logfile);
                    }
                }

                $command = str_replace(array(chr(10), chr(13)), '', $this->ex[3]);

                switch($command) //List of commands the bot responds to from a user.
                {

            /*
                        start my edit1
                        */

                        case ':!logger':
                                $message = "";
                                for($i=4; $i <= (count($this->ex)); $i++)
                                {
                                        $message .= $this->ex[$i]." ";
                                }
                       $this->send_data('PRIVMSG '.$config['channel'].' :', ("http://slopwiki.com/logs/$date-log.html"), $message);
                                break;
                        /*
                        end my edit 1
            */


            case ':!join':
                                $this->join_channel($this->ex[4]);
                                break;

                        case ':!quit':
                                $this->send_data('QUIT', 'sysop made Bot');
                                break;

                        case ':!op':
                                $this->op_user();
                                break;

/*
                case ':!deop':
                                $this->op_user(); false;
                                break;
*/

                        case ':!protect':
                                $this->protect_user();
                                break;


                        case ':!say':
                                $message = "";
                                for($i=4; $i <= (count($this->ex)); $i++)
                                {
                                        $message .= $this->ex[$i]." ";
                                }

                                $this->send_data('PRIVMSG '.$config['channel'].' :', $message);
                                break;

                        case ':!restart':
                                 //Warn that logging has been disabled
                                 if($config['warning']) {
                                 $this->send_data('PRIVMSG '.$config['channel'].' :', "Chat Logging has been [Disabled]");
                                   }

                                echo "";
                                if($config['logging']) {
                                        $date = date("y-n-j");
                    $time = date('h:i:s A');
                                        $logfile = fopen("$date-log.html","a");
                                        fwrite($logfile,"
**************** Logging Ended at $date $time ****************
");
                                        fclose($logfile);
                                 }
                                exit;


                case ':!shutdown':
                                //Warn that logging has been disabled
                                if($config['warning']) {
                                    $this->send_data('PRIVMSG '.$config['channel'].' :', "Chat Logging has been [Disabled]");
                                   }

                                if($config['logging']) {
                                        $date = date("y-n-j");
                    $time = date('h:i:s A');
                                        $logfile = fopen("$date-log.html","a");
                                        fwrite($logfile,"
**************** Logging Ended at $date $time ****************
");
                                        fclose($logfile);
                                 }
                                exit;
                }

                $this->main($config);
        }


        /* --- IRCBot Class's Functions --- */

        function filter_log($type, $chan, $nick, $msg)
        {
            $nick = ltrim($nick, ":");
            $nick = substr($nick, 0, strpos($nick, "!"));

            $msg = ltrim($msg, ":");

            if($type == "PRIVMSG")
            {
                return date("[H:i]")." <".$nick."> ".$msg;
            }
            return null    ;
        }

        function get_msg($arr)
        {
            $message = "";
            for($i=3; $i <= (count($this->ex)); $i++)
            {
              $message .= $this->ex[$i]." ";
            }
            return $message;
        }

        function send_data($cmd, $msg = null) //displays stuff to the broswer and sends data to the server.
        {
                if($msg == null)
                {
                        fputs($this->socket, $cmd."\r\n");
                        echo ''.$cmd.'';
                } else {

                        fputs($this->socket, $cmd.' '.$msg."\r\n");
                        echo ''.$cmd.' '.$msg.'';
                }

        }



        function join_channel($channel) //Joins a channel, used in the join function.
        {
                if(is_array($channel))
                {
                        foreach($channel as $chan)
                        {
                                $this->send_data('JOIN', $chan);
                        }

                } else {
                        $this->send_data('JOIN', $channel);
                }
        }



        function protect_user($user = '')
        {
                if($user == '')
                {
                        if(php_version() >= '5.3.0')
                        {
                                $user = strstr($this->ex[0], '!', true);
                        } else {
                                $length = strstr($this->ex[0], '!');
                                $user   = substr($this->ex[0], 0, $length);
                        }
                }

                $this->send_data('MODE', $this->ex[2] . ' +a ' . $user);
        }

        function op_user($channel = '', $user = '', $op = true) {
        if($channel == '' || $user == '')
                {
                        if($channel == '')
                        {
                                $channel = $this->ex[2];
                        }

                        if($user == '')
                        {

                if(php_version() >= '5.3.0')
                                {
                                        $user = strstr($this->ex[0], '!', true);
                                } else {
                                        $length = strstr($this->ex[0], '!');
                                        $user   = substr($this->ex[0], 0, $length);
                                }
                        }
                }


                if($op)
                {
                        $this->send_data('MODE', $channel . ' +o ' . $user);
                } else {
                        $this->send_data('MODE', $channel . ' -o ' . $user);
                }
        }
}

//Start the bot
$bot = new IRCBot($config);
?>
