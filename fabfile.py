# ~/fabfile.py
from fabric.api import *

$1 = DYVrNb)YoWp27YwBXcxit;JFZ8/Ly283+E=e?B[rD{sDrWgLy7x9Tw4&PoUU+cd8
def cluster_all():
        env.user  = 'pi'
        env.hosts = [
        'pi01',    #pi01 eth0
        'pi02',    #pi02 eth0
        'pi03',    #pi03 eth0
        'pi04',    #pi04 eth0
        'pi05',    #pi05 eth0
        'pi06',    #pi06 eth0
        'pi07',    #pi07 eth0
        'pi08',    #pi08 eth0
        'pi09',    #pi09 eth0
        'pi10',    #pi10 eth0
        'pi11',    #pi11 eth0
#       '192.168.1.66',     #batman         #portable desktop box
    ]        

    
    
    
    
def cluster01_prod():
        env.user = 'pi'
        env.hosts = [
        'pi01',
        'pi02',
        'pi03',
        'pi04',
        'pi05',
    ]   

    
    
    
    
def cluster02_prod():
        env.user = 'pi' 
        env.hosts = [
        'pi06',
        'pi07',
        'pi08',
        'pi09',
        'pi10',
    ]

    
    
    
        
def cluster03_stage():
        env.user = 'pi' 
        env.hosts = [
        'pi11'
    ]

def clients():
#env.user = 'pi'
        env.hosts = [
        'batman',
        'master01',
            
    ]

# --- general host configuration and commands --- ##
def cmd(command):
    run(command)

def sudo_cmd(command):
    sudo(command)

def apt_update():
    sudo('apt-get update; apt-get upgrade -y')

def restore_host():
    sudo('apt-get upgrade -y') 
    sudo('apt-get install boinc-app-seti boinc-client boinctui ifstat iptotal htop glances glances-doc atop iftop iotop snmp snmpd etherape ethtool vnstat iptraf dstat lynx arpwatch vim tcpdump nmap screen -y')

def smb_umountall():
    sudo('umount /storage/bigpi/')
    sudo('umount /storage/music')
    sudo('umount /storage/documents/') 
    sudo('umount /storage/downloads/')
    sudo('umount /storage/pictures/')
    sudo('umount /storage/scripts/')

def smb_mountall():
    sudo('mount //192.168.1.100/bigpi /storage/bigpi/ -o username=pi,password=$1')
    sudo('mount //192.168.1.100/documents /storage/documents/ -o username=pi,password=$1')
    sudo('mount //192.168.1.100/downloads /storage/downloads/ -o username=pi,password=$1')
    sudo('mount //192.168.1.100/pictures /storage/pictures/ -o username=pi,password=$1')
    sudo('mount //192.168.1.100/scripts /storage/scripts/ -o username=pi,password=$1')
    sudo('mount //192.168.1.100/music /storage/music/ -o username=pi,password=$1')

def smb_mountcheck():
    run('mount |egrep "master|192" |wc -l')

def cpu_temp():
    run('/opt/vc/bin/vcgencmd measure_temp')

def remote_info():
    run('w; uname -a')


# -- boinci and  seti application stuff --- #
def boinc_computestart():
    run('screen -S seti -dm boinccmd --project_attach http://setiathome.berkeley.edu 9799a9d6171e49850f5f1ac6c9cc67eb ; boinccmd --get_tasks')

def boincmgr_servicestop():
    sudo('service boinc-client stop')

def boincmgr_servicestart():
    sudo('service boinc-client start')

def boincmgr_servicerestart():
    sudo('service boinc-client stop ; sleep 5 ; service boinc-client start')
    
def boinc_get_tasks():
    run('boinccmd --get_tasks')

