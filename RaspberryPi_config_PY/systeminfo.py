from datetime import datetime
import os
import json
#import psutil
class systeminfo():
	@staticmethod
	def getSerial():
		#Return the SerialNumber of raspberrypi
		f = open('/proc/cpuinfo','r')
		cpuserial = "0000000000000000"
		try:
    			f = open('/proc/cpuinfo','r')
			for line in f:
				if line[0:6]=='Serial':
					cpuserial = line[10:26]
			f.close()
		except:
			cpuserial = "ERROR000000000"

		return cpuserial
	
	@staticmethod
	def getMac():
		# Return the MAC address of interface
		try:
			str = open('/sys/class/net/eth0/address').readline()
		except:
			str = "00:00:00:00:00:00"
		str = str.replace(':','')
		str = str.replace('\n','')
		return str
	
	
	@staticmethod
	def getUptime():
		dataFile=open("/proc/uptime")
		contents = dataFile.read().split()
		dataFile.close()
		return contents[0]

	@staticmethod
	def getRam():
		p = os.popen('free')
		i = 0
		while 1:
			i = i + 1
			line = p.readline()
			if i==2:
				return(line.split()[1:4])
	
	@staticmethod
	def getStorage():
		p = os.popen("df -h /")	
		i = 0
		while 1:
			i = i +1
			line = p.readline()
			if i==2:
				return(line.split()[1:5])
	@staticmethod
	def getCputemp():
		res = os.popen('vcgencmd measure_temp').readline()
		return(res.replace("temp=","").replace("'C\n",""))
	
	@staticmethod
	def getBandwidthUsage():
		DIR = '/home/pi/mine/net_traffic'
		d =datetime.now()
		if(os.path.isfile(DIR+"/"+d.strftime('%Y-%m-%d')+"-tx")):  #check if th$
			fo = open(DIR+"/"+d.strftime('%Y-%m-%d')+"-tx", "rw+")
			txline = fo.readline().replace('\n','')
			fo1 = open(DIR+"/"+d.strftime('%Y-%m-%d')+"-rx", "rw+")
			rxline = (fo1.readline()).replace('\n','')
			return [txline,rxline]
	
	@staticmethod
	def getCpuLoad():
		return(str(os.popen("sudo top -b -n1 | awk '/Cpu\(s\):/ {print $2}'").readline().strip()))
	

	@staticmethod
	def getData():
		data = {'uptime': systeminfo.getUptime(),
			'ram':  systeminfo.getRam(),
			'cpu':  systeminfo.getCpuLoad(),
			'cputemp':  systeminfo.getCputemp(),
			'storage':  systeminfo.getStorage(),
			'bandwidth':  systeminfo.getBandwidthUsage(),
			}
		return  data
