#!/bin/bash
#---------------------------------#
#   ---   master nodes [1-2]   ---#
# ssh 192.168.1.100 # master node 1
# ssh 192.168.1.101 # master node 2
#---------------------------------#

# --- cluster 1 compute nodes --- #
#ssh 192.168.1.201 # compute node 1
#ssh 192.168.1.202 # compute node 2
#ssh 192.168.1.203 # compute node 3
#ssh 192.168.1.204 # compute node 4
#ssh 192.168.1.205 # compute node 5
#---------------------------------#

# --- cluster 2 compute nodes --- #
#ssh 192.168.1.206 # compute node 6
#ssh 192.168.1.207 # compute node 7
#ssh 192.168.1.208 # compute node 8
#ssh 192.168.1.209 # compute node 9
#ssh 192.168.1.210 # compute node 10
#---------------------------------#

ST='1'
CDM=echo ` `
M1="Please select your compute node [01-10]"
M2="MASTER node options are  [11 and 12]"

while :;do clear	
	
		PS3='Choice:  ' #get the user's input for options 1-12
		$CDM; echo $M1;
		echo $M2; $CDM

				options=("Node 1" 
				         "Node 2"
					 "Node 3"
					 "Node 4"
					 "Node 5"
					 "Node 6"
					 "Node 7"
					 "Node 8"
					 "Node 9"
					 "Node 10"
					 "Node 11"
					 "Node 12"
					 "Node 13"
					 )

select opt in "${options[@]}"
					
	do
	case $opt in

		"Node 1")
	                clear ; echo ""; echo "Entering compute node 1" ; echo ""
			sleep $ST ; ssh 192.168.1.201 ; clear; echo $M1, $M2
			;;

		"Node 2")
			clear ; echo "" ;echo "Entering compute node 2" ; echo ""
			sleep $ST ;ssh 192.168.1.202; clear; echo $M1, $M2	
			;;

		"Node 3")
 	               echo "Entering compute node 3"
			sleep $ST; ssh 192.168.1.203; clear ; echo $M1, $M2
			;;


		"Node 4")
 	               echo "Entering compute node 4"
			sleep $ST; ssh 192.168.1.204; clear; echo $M1, $M2
			;;

		"Node 5")
			echo "Entering compute node 5"
			sleep $ST; ssh 192.168.1.205; clear; echo $M1, $M2
		;;

		"Node 6")
 	               echo "Entering compute node 6"
			sleep $ST; ssh 192.168.1.206; clear; echo $M1, $M2
			;;


		"Node 7")
   	             echo "Entering compute node 7"
			sleep $ST; ssh 192.168.1.207; clear; echo $M1, $M2
			;;

#		"Node 8")
#			echo "Entering compute node 8"
#			sleep $ST; ssh 192.168.1.208; clear; echo $M1, $M2
#			;;

#		"Node 9")
#	                echo "Entering compute node 9"
#			sleep $ST; ssh 192.168.1.209; clear; echo $M1, $M2
#			;;

#		"Node 10")
#        	        echo "Entering compute node 10"
#			sleep $ST; ssh 192.168.1.210; clear; echo $M1, $M2
#			;;
	
		"Node 11")
			echo "Entering MASTER-01"
			sleep $ST; ssh 192.168.1.100; clear; echo $M1, $M2
			;;

#		"Node 12")
#			echo "Entering MASTER-002"
#			sleep $ST; ssh 192.168.1.101; clear; echo $M1, $M2
#			;;


		".")
			break; exit 0 ;;

	*) echo invalid option;;
	      esac
			done
				done
