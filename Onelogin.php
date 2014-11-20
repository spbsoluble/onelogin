/*

*/

<?php
	class Onelogin {
		$api_token = '';
		$api_urls = array(
			'user' => 'https://app.onelogin.com/api/v3/users/username/',
			'users' => 'https://app.onelogin.com/api/v3/users.xml',
			'event' => 'https://app.onelogin.com/api/v1/events/',
			'events' => 'https://app.onelogin.com/api/v1/events.xml',
		);

		__construct($token){
			$this->api_token = $token;
		}

		public function getUser($username){
			$command = $this->createCURL('GET','user',$username);
			return $this->xml2json($this->sendCommand($command));		
		}

		public function getUsers($users = array()){
			$users = array();
			foreach ($user as $key => $username){
				$users[$username] = $this->getUser($username);
			}
			return $users;
		}

		public function getAllUsers(){
			$command = $this->createCURL('GET','users');
			return $this->xml2json($this->sendCommand($command));
		}	

		public function getUserID($username){
			$user = $this->getUser($username);
			return $user['id'];
		}

		public function getUserIDs($usernames = array()){
			$users = $this->getUsers($usernames);
			$userIDs = array();
			foreach ($users as $username => $userData){
				$userIDs[$username] = $userData['id']; 
			}
			return $userIDs;
		}

		public function getEvents($filters = array()){
			
		}

		public function getAllEvents($filters = array()){
			
		}

		private function changeUserStatus($status){
			
		}

		public function suspendUser($username){
			
		}

		public function suspendUsers($users = array()){
			
		}

		public function activateUser($username){
			
		}

		public function activateUsers($users = array()){
			
		}

		public function deleteUser($username){
			$command = $this->createCURL('DELETE','user',$username);
			return $this->sendCommand($command);
		}

		public function deleteUsers($users = array()){
			foreach ($users as $key => $username){
				$this->deleteUser($username);
			}
			return;
		}

		public function changeUserStatuses($status,$users = array()){
			
		}

		public function createUser($userInfo){
			
		}

		private function xml2json($xml){
			#$json = simplexml_load_string($xml);
                	#$encode = json_encode($json);
                	#return json_decode($encode,TRUE));
			return json_decode(($json_encode(simplexml_load_string($xml))), true);
			
		}

		private function setURL($apiTarget,$etc){
			switch($apiTarget){
				case 'user':
					return $this->api_urls['user'].$etc.'.xml';
				case 'users':
					return $this->api_urls['users'];
				case 'event':
					return $this->api_urls['event'].$etc.'.xml';
				case 'events':
					return $this->api_urls['events'];
				default:
					echo 'bad things happened you gave an invalid API target';
					return NULL;
			}
		}
	
		private function createCURL($cURLOperation,$apiOperation, $etc = ''){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_USERPWD, $this->api_token);
			$url = $this->setURL($apiOperation,$etc);

			if(!empty($url)){
				curl_setopt($ch, CURLOPT_URL, $url);
			} else {
				echo 'Bad things happened determining the URL to use';
			}

			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,false);

			switch($cURLOperation){
				case 'GET' :
				        curl_setopt($ch, CURLOPT_HTTPGET, 1);
					curl_setopt($ch, CURLOPT_HEADER, false); #needs to be false for json encoding
					break;
				case 'POST':
					break;

				case 'DELETE' :
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'DELETE');
					curl_setopt($ch, CURLOPT_HEADER, true); #set to true so I get some sort of response back as no XML is returned
					break;
				default:
					curl_setopt($ch, CURLOPT_HTTPGET, 1);
					curl_setopt($ch, CURLOPT_HEADER, false); #needs to be false for json encoding
					break;
			}
			return $ch;	
		}

		private function sendCommand($cURLCommand){
			$result = curl_exec($cURLCommand);
			curl_close($cURLCommand);
			return $result;			
		}

	}
?>
