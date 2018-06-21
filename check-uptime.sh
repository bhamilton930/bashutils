for i in {1..11}

do

clear ; 

ssh 192.168.1.20$i echo `hostname` ; w; echo ""; uptime; echo "" 
done

#ssh 192.168.1.104 echo `hostname` ; w; echo ""; uptime; echo ""
