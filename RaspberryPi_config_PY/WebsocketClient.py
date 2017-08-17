#!/usr/bin/env python
import sys, time, logging, os, websocket, thread, threading, json, subprocess
from systeminfo import systeminfo
from datetime import datetime
from ssh import ssh
from daemon import Daemon


class WebsocketClient(Daemon):


	def run(self):
		

		def updateBandwidthdata():
  			threading.Timer(60.0, updateBandwidthdata).start()
			os.system('sudo bash /home/pi/mine/bandwithmoniter.sh')		

		def bandwidthdatatoDb():
			threading.Timer(43200.0,bandwidthdatatoDb).start() #this functions runs every 12 hours or when the daemon is re/started
			os.system("sudo python /home/pi/mine/updateBandwithinfo.py &")

		
		def logger(log,er=None):
			f = open('/home/pi/mine/log','a')
			f.write(str(datetime.now())+'  '+log+'\n')
			if er is not None:
				print>>f,er
				f.write('\n')
			f.close()
				
		def connect(url):
			def on_message(ws, message):
				logger('Message Received '+ url +'\n'+message)
				message = json.loads(message)
				if message['type'] == 'cmd':
					if message['cmd'] == 'shutdown':
						ws.close
						os.system("sudo shutdown -h now")	 
					elif message['cmd'] ==  'reboot':
						os.system("sudo reboot")
						#reboot()
						#print 'still running'
					elif  message['cmd'] ==  'openTunnel':
						ssh.reverseSShinit()
						mac = systeminfo.getMac()
						data  ={'type':'ack','ack':'2','macAdd':mac}
						print data
						ws.send(json.dumps(data))
						#print 'opencon'
				elif message['type']== 'request':
					data = {'type':'response','response':{}}
					data['response'] = systeminfo.getData()
					#print json.dumps(data)
					ws.send(json.dumps(data))
				
							


			def on_error(ws, error):
				logger('Socket Closed with error '+ url,error)

				#if the connection closes with error thaen wait 30 seconds  nad try connecting again	
				#time.sleep(10)
				connect(url)
				
				#print ( str(datetime.now())+" --" + "---error")
				#os.system("sudo python /home/pi/mine/example1.py")
				#print (error)
				
				#time.sleep(30)
				
				#os._exit(0)

			def on_close(ws):
				logger('Socket Closed '+ url +'\n')
				#time.sleep(10)
				connect(url)
				#if the connection is closed  then wait 30 seconds and try again
				#os.system("sudo python /home/pi/mine/example1.py")
				#
				#os._exit(0)

			def on_open(ws):
				logger('Socket Opened '+ url)
				def run(*args):
				#	for i in range(3):
				#		time.sleep(1)
				#		ws.send("Hello %d" % i)
				#	
					# ws.close()
					time.sleep(1)
					print ( str(datetime.now())+" -- Connection initiated")
					thread.start_new_thread(run, ())
			
			logging.basicConfig()

			mac = systeminfo.getMac()
			serial=systeminfo.getSerial()
			ws = websocket.WebSocketApp(url, 
					  on_message = on_message,
									  on_error = on_error,
									  on_close = on_close,
					  header = ["macaddress:"+mac,"serial:"+serial])
			ws.on_open=on_open
			ws.run_forever()
		
		updateBandwidthdata()
		bandwidthdatatoDb()
		connect("ws://sastotest.info:9000/")

if __name__ == "__main__":
#	websocket.enableTrace(True)	
	daemon = WebsocketClient('/var/run/WebsocketClient.pid')
	if len(sys.argv) == 2:
		if 'start' == sys.argv[1]:
			print('Websocket Client Started'+os.getcwd())
			daemon.start()
		elif 'stop' == sys.argv[1]:
			print('Websocket Client Stopped')
			daemon.stop()
		elif 'restart' == sys.argv[1]:
			print('Websocket Client Restarting')
			daemon.restart()
		else:
			print "Unknown command"
			sys.exit(2)
		sys.exit(0)
	else:
		print "usage: %s start|stop|restart" % sys.argv[0]
		sys.exit(2)
	
	
