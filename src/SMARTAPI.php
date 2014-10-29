<?php

	/**
	 * SMART API PHP Library - A library to connect on S.M.A.R.T platform to integrate webpages with smart data.
	 *
	 * @author  José Wilker <jose.wilker@smartapps.com.br>
	 *
	 * @copyright 2014
	 *
	 */

	class SMARTAPI {

		var $base_url = URL_BASE;
		var $api_url = API_URL;

		var $connect = false;

		var $api_user = API_USER;
		var $api_key = API_KEY;

		var $node = "from";

		public function __construct() {
			if (session_id() == "") {
				session_start();
			}
		}

		/*
		 * Metódo para conectar a plataforma
		 */
		public function connect($app, $api_user=false, $api_key=false) {

			$this->connect = "from";

			if (empty($_SESSION)) {

				$curl = curl_init();

				$ckfile = tempnam("/tmp", "PHPSESSID");

				if (!empty($api_user)) { $this->api_user = $api_user; }
				if (!empty($api_key)) { $this->api_key = $api_key; }

				$this->api_url_conn = $this->api_url;

				curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
				curl_setopt($curl, CURLOPT_USERPWD, "{$this->api_user}:{$this->api_key}");
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_URL, $this->api_url_conn  . "/" . $this->node . "/" . $app);

				$curl_exec = curl_exec($curl);

				if (!empty($curl_exec)) {
					$this->obj->connect = json_decode($curl_exec);
				} else {
					$this->obj->connect = false;
				}

				if (is_string($curl_exec) && empty($this->obj->connect)) {
					exit($curl_exec);
				}

				$this->obj->cookie_data = "{$this->obj->connect->data->name}={$this->obj->connect->data->id};";

				$this->obj->url_base = $this->api_url_conn;
				$this->obj->app = $app;
				$this->obj->api_user = $this->api_user;
				$this->obj->api_key = $this->api_key;
				$this->obj->cookie_file = $ckfile;

				curl_close($curl);

				$_SESSION["api"] = $this->obj;

			} else {

				$curl = curl_init();

				$this->api_url_conn = $this->api_url . "/conn";

				curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
				curl_setopt($curl, CURLOPT_USERPWD, "{$this->api_user}:{$this->api_key}");
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_URL, $this->api_url_conn);

				$curl_exec = curl_exec($curl);

				curl_close($curl);

				$connection = json_decode($curl_exec);

				if (empty($connect) || $connection->data->status == "error") {
					session_destroy();
					$_SESSION = "";
					return $this->connect($app, $api_user, $api_key);
				} else {
					$this->obj = $_SESSION["api"];
				}


			}

			return $this->obj;

		}

		public function connectionClose() {

			$curl = curl_init();

			$this->api_url_exec = $this->api_url . "/close";

			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, "{$this->api_user}:{$this->api_key}");
			curl_setopt($curl, CURLOPT_HEADER, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
			curl_setopt($curl, CURLOPT_URL, $this->api_url_exec);

			$curl_exec = curl_exec($curl);

			curl_close($curl);

			session_destroy();

			return json_encode($curl_exec);

		}

		private function _execInsert($conn, $option, $params, $return) {

			$curl = curl_init();

			$this->node = "exec";

			$this->api_url_exec = $this->api_url . "/" . $this->node . "/" . $return . "/" . $option . "/insert";

			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
			curl_setopt($curl, CURLOPT_USERPWD, "{$this->api_user}:{$this->api_key}");
			curl_setopt($curl, CURLOPT_HEADER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
			curl_setopt($curl, CURLOPT_COOKIE, $conn->cookie_data);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $conn->cookie_file);
			curl_setopt($curl, CURLOPT_URL, $this->api_url_exec);

			$curl_exec = curl_exec($curl);

			curl_close($curl);

			$arrayData = json_decode($curl_exec);

			return $arrayData;

		}

		/*
		 * Metódo privado para fazer chamadas simples.
		 */
		private function _get($conn, $option="_schemas", $app=false) {

			$curl = curl_init();

			$this->node = "from";

			if (!$app) { $app = $conn->app; }

			$this->api_url_get = $conn->url_base  . "/" . $this->node . "/" . $app . "/" . $option;

			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
			curl_setopt($curl, CURLOPT_USERPWD, "{$conn->api_user}:{$conn->api_key}");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_COOKIE, $conn->cookie_data);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $conn->cookie_file);
			curl_setopt($curl, CURLOPT_URL, $this->api_url_get);
			curl_setopt($curl, CURLOPT_VERBOSE, 1);

			$curl_exec = curl_exec($curl);

			curl_close($curl);

			$arrayData = json_decode($curl_exec);

			return $arrayData;

		}

		/*
		 * Metódo privado para fazer chamadas simples.
		 */
		private function _to($conn, $option="_schemas", $form, $postVars=false, $app=false) {

			$curl = curl_init();

			$this->node = "to";

			if (!$app) { $app = $conn->app; }

			$this->api_url_get = $conn->url_base  . "/" . $this->node . "/" . $app . "/" . $option . "/" . $form;

			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
			curl_setopt($curl, CURLOPT_USERPWD, "{$conn->api_user}:{$conn->api_key}");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_COOKIE, $conn->cookie_data);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $conn->cookie_file);
			curl_setopt($curl, CURLOPT_URL, $this->api_url_get);
			curl_setopt($curl, CURLOPT_VERBOSE, 1);

			if (is_array($postVars)) {
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $postVars);
			}

			$curl_exec = curl_exec($curl);

			curl_close($curl);

			$arrayData = json_decode($curl_exec);

			return $arrayData;

		}

		/*
		 * Executa um metódo diretamente na api
		 */
		public function method($conn, $schema, $method, $args=false, $return="json", $app=false) {

			$curl = curl_init();

			$this->node = "exec";
			if (!$app) { $app = $conn->app; }

			$this->api_url_get = $conn->url_base  . "/" . $this->node . "/" . $return . "/" . $app . "/" . $schema . "/" . $method;

			if ($args) {
				$this->api_url_get = $this->api_url_get . "/" . $args;
			}

			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
			curl_setopt($curl, CURLOPT_USERPWD, "{$conn->api_user}:{$conn->api_key}");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_COOKIE, $conn->cookie_data);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $conn->cookie_file);
			curl_setopt($curl, CURLOPT_URL, $this->api_url_get);
			curl_setopt($curl, CURLOPT_VERBOSE, 1);

			$curl_exec = curl_exec($curl);

			curl_close($curl);

			$arrayData = json_decode($curl_exec);

			return $arrayData;

		}

		public function methodPost($conn, $schema, $method, $postVars, $args=false, $return="json", $app=false) {

			$curl = curl_init();

			$this->node = "exec";
			if (!$app) { $app = $conn->app; }

			$this->api_url_get = $conn->url_base  . "/" . $this->node . "/" . $return . "/" . $app . "/" . $schema . "/" . $method;

			if ($args) {
				$this->api_url_get = $this->api_url_get . "/" . $args;
			}

			//$postVars = array('data' => serialize($postVars));
			//print_r($postVars);

			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
			curl_setopt($curl, CURLOPT_USERPWD, "{$conn->api_user}:{$conn->api_key}");
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postVars);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_COOKIE, $conn->cookie_data);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $conn->cookie_file);
			curl_setopt($curl, CURLOPT_URL, $this->api_url_get);
			curl_setopt($curl, CURLOPT_VERBOSE, 1);

			$curl_exec = curl_exec($curl);

			curl_close($curl);

			$arrayData = json_decode($curl_exec);

			return $arrayData;

		}

		/*
		 * Metódo disponível para obter todos os schemas
		 */
		public function getSchemas($conn) {

			if (empty($conn)) {
				exit('Não foi possível encontrar as definições de conexão.');
			}

			$schemas = $this->_get($conn, '_schemas');

			return $schemas;

		}

		/*
		 * Metódo disponível para obter todos os formulários
		 */
		public function getForms($conn, $schema) {

			if (empty($conn)) {
				exit('Não foi possível encontrar as definições de conexão.');
			}
			$forms = $this->_get($conn, "{$schema}/_forms");
			return $forms;
		}

		/*
		 * Metódo disponível para obter conteúdo
		 */
		public function getData($conn, $schema, $form) {

			if (empty($conn)) {
				exit('Não foi possível encontrar as definições de conexão.');
			}

			$content = $this->_get($conn, "{$schema}/{$form}");

			return $content;

		}

		/*
		 * Metódo disponível para carregar arquivos de forma remota
		 */
		public function getFile($conn, $file, $mime, $date) {

			if (empty($conn)) {
				exit('Não foi possível encontrar as definições de conexão.');
			}

			$app = $conn->app;

			// get details from account
			$content = $this->getData($conn, "_details");

			$url_file = $this->base_url . "/file.php?a=" . $content->data->account . "&app=" . $app . "&f=" . $date . "/" . $file . "&sid=" . $content->data->sessionid . "&m=" . $mime;

			return $url_file;

		}

		/*
		 * Metódo disponível para enviar informações
		 */
		public function sendExec($conn, $app, $schema, $form, $postVars, $return="json") {

			if (empty($conn)) {
				exit('Não foi possível encontrar as definições de conexão.');
			}

			$content = $this->_execInsert($conn, "{$app}/{$schema}/{$form}", $postVars, $return);

			return $content;

		}

		/**
		 * Metódo disponível para enviar uma chamada para um form.
		 * @param  [type]  $conn     [description]
		 * @param  [type]  $schema   [description]
		 * @param  boolean $postVars [description]
		 * @param  boolean $app      [description]
		 * @return [type]            [description]
		 */
		public function sendTo($conn, $schema, $form, $postVars=false, $app=false) {

			if (empty($conn)) {
				exit('Não foi possível encontrar as definições de conexão.');
			}

			$content = $this->_to($conn, $schema, $form, $postVars, $app);

			return $content;

		}

	}
?>
