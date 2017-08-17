class logger():
	@staticmethod		
	def log(logmsg,er=None):
		f = open('/home/pi/mine/log','a')
		f.write(str(datetime.now())+'  '+logmsg+'\n')
		if er is not None:
			print>>f,er
			f.write('\n')
		f.close()