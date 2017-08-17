#This script will run everytime when the raspberry pi boots up
#it checks the bandwith usage from yesterday that is stored in a file named as "mysql-format-date-tx/rx"
#reads the data and uploads it to mysql and removes the file

from datetime import date, datetime
from datetime import timedelta
import time
import os, os.path
import sys
import MySQLdb
from systeminfo import systeminfo

today =datetime.now()
cursor=None
cnx =None
DIR = '/home/pi/mine/net_traffic'
length = (len([name for name in os.listdir(DIR) if os.path.isfile(os.path.join(DIR, name))]))

def logger(log,er=None):
	f = open('/home/pi/mine/log','a')
	f.write(str(datetime.now())+'  '+log+'\n')
	if er is not None:
		print>>f,er
		f.write('\n')
	f.close()


def getConn():
	try:
		cnx =  MySQLdb.connect(host="sastotest.info",user='root',passwd='1991mpjg',db='bigyapan')
		cursor = cnx.cursor()
		return True
		
		
	except MySQLdb.Error, e:
		return e

def daterange(start, end, delta): #date range function returns the dates between given time
    """ Just like `range`, but for dates! """
    current = start
    while current > end:
        yield current
        current -= delta


start = datetime.now()-timedelta(days=(1)) #update the value from file from yesterday
end = start - timedelta(days=(length)) #get the oldest file if exists

def updateTodb(Date,MacAdd,Rx,Tx):
	update_bandwidth = ('INSERT INTO bandwidth (Date,MacAdd, Rx, Tx) VALUES ("%s","%s","%s","%s")' % (Date,MacAdd,Rx,Tx))
	cursor.execute(update_bandwidth)
	cnx.commit()
	if(cursor.rowcount==1):#if update sucessfull delete the files
		os.remove(DIR+"/"+Date+"-tx")
		os.remove(DIR+"/"+Date+"-rx")	


def execute():
	if (getConn() == True):
		print(getConn)
		for d in daterange(start, end, timedelta(days=1)): # files in range from testerday to oldest file read value update to database and delete
			if(os.path.isfile(DIR+"/"+d.strftime('%Y-%m-%d')+"-tx")):  #check if the file exists
				fo = open(DIR+"/"+d.strftime('%Y-%m-%d')+"-tx", "rw+") 
    				txline = fo.readline().replace('\n','')
   				fo1 = open(DIR+"/"+d.strftime('%Y-%m-%d')+"-rx", "rw+")
    				rxline = (fo1.readline()).replace('\n','')
 
	    			updateTodb(d.strftime('%Y-%m-%d'),systeminfo.getMac(),rxline,txline)  #update to database
		logger('Bandwidth data uploaded',er=e)
		cursor.close()
		cnx.close()
	else:
		e = getConn()
		print(e)
		sys.stderr.write("[ERROR] %d: %s\n"% (e.args[0], e.args[1]))
		logger('Connection Error. Failed uploading bandwidth data',er=e)
		time.sleep(60)
		execute()
execute()
