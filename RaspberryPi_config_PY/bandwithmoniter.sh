#!/bin/bash
##
##This script return the bandwidth usage in a day in  Rx and Tx 
##This script is called every 1 minute so that if the raspberry pi doesnot shut down safely the data can be still retained.
##This will store the rx and tx file with name date-tx, date-rx
## 

# Location of the networkTraffic files
LOCATION="/home/pi/mine/net_traffic"
NOW=$(date +"%F")

# Test if directory $path exist then create it
if [ ! -d $LOCATION ]
then    mkdir $LOCATION
fi

# Test if file rx exist then create it
if [ ! -f $LOCATION/$NOW-rx ]
then    touch $LOCATION/$NOW-rx
fi

# Test if file tx exist then create it
if [ ! -f $LOCATION/$NOW-tx ]
then    touch $LOCATION/$NOW-tx
fi

# Get old values in rx/tx files
OLDRX=`cat $LOCATION/$NOW-rx`
OLDTX=`cat $LOCATION/$NOW-tx`

# Get new values
RX=`cat /sys/class/net/eth0/statistics/rx_bytes`
TX=`cat /sys/class/net/eth0/statistics/tx_bytes`

# Store new values in rx/tx files
echo $RX > $LOCATION/$NOW-rx
echo $TX > $LOCATION/$NOW-tx

# If the old  value is bigger than new value then pi rebooted 
# Add the new value to old value else Replace the old value with new value

if [ $OLDRX -gt $RX ]
then 
	RX_NEW=$(($RX+$OLDRX))
	TX_NEW=$(($TX+$OLDTX))
	
else
	RX_NEW=$RX
	TX_NEW=$TX
fi

echo $RX_NEW>$LOCATION/$NOW-rx
echo $TX_NEW>$LOCATION/$NOW-tx

# Display traffic value in stdout
echo -e "rx=$RX_NEW\ntx=$TX_NEW\n"
echo -e "rx_value=$RX\ntx_value=$TX"
