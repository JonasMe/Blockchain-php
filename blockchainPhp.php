<?php

	/* 
		The MIT License (MIT)

		Copyright (c) 2014 JonasMe

		JonasMe
		jonas@mersholm.dk

		Donations are greatly appreciated at : 1E4FU9CErrDatuHojDoudEuqjSadB1sRaJ

		Permission is hereby granted, free of charge, to any person obtaining a copy
		of this software and associated documentation files (the "Software"), to deal
		in the Software without restriction, including without limitation the rights
		to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
		copies of the Software, and to permit persons to whom the Software is
		furnished to do so, subject to the following conditions:

		The above copyright notice and this permission notice shall be included in all
		copies or substantial portions of the Software.

		THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
		IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
		FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
		AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
		LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
		OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
		SOFTWARE.
	*/

	class BlockchainPhp {

		private $identifier;
		private $mainPassword;
		private $secondPassword;
		private $merchantUrl;
		private $apiUrl;
		private $generatedUrl;
		private $language;

		public function __construct($identifier, $mainPassword = null, $secondPassword = null) {
				$this->identifier  		= $identifier;
				$this->mainPassword 	= $mainPassword;
				$this->secondPassword 	= $secondPassword;
				$this->merchantUrl		= "https://blockchain.info/%s/merchant/%s/";
				$this->apiUrl			= "https://blockchain.info/da/api/";
				$this->language 		= "en";
 		}

 		//Public API functionality
 		/**
 		 * Creates a unique address which should be presented to a customer.
 		 * @param  string $address  The wallet public key where the payment should be send
 		 * @param  string $callback The callback url at which you want to confirm the payment
 		 * @return object           Object containing the response
 		 */
 		public function generateReceiveToken($address, $callback) {
 			$extras = array(
 				"method" => "create",
 				"address" => $address,
 				"callback" => $callback,
 			);
 			return $this->apiCall("receive",$extras);
 		}

 		//Merchant API functionality

 		/**
 		 * Payment function. Send a payment to a public key
 		 * @param  string $recipient address key of recipient
 		 * @param  numeric $amount    Amount of Bitcoins to send.
 		 * @param  array  $extras    Optional fields may be added as array properties. 
 		 * @return object            object containing the response.
 		 */
 		public function pay($recipient, $amount, $extras = array() ) {
 			if( !is_null($this->mainPassword) ) {
 				
 					$extras["password"] = $this->mainPassword;
 					$extras["to"]		= $recipient;
 					$extras["amount"]	= $this->BTCToSatoshi( $amount );

 					if( !is_null($this->secondPassword)) { $extras["second_password"] = $this->secondPassword; }
 					return $this->merchantApiCall("payment",$extras);
 			} else {
 				throw new Exception("To use the 'pay' api method, you must specify a main password");
 			}
 		}

 		/**
 		 * Fetch the balance of a wallet. This should be used as an estimate only. Amount is in Satoshi, you may convert with the satoshiToBTC method
 		 * @return object Object containing the response.
 		 */
 		public function balance() {
 			if( !is_null($this->mainPassword) ) {
 				$extras = array( "password" => $this->mainPassword );
 				return $this->merchantApiCall("balance",$extras);
			} else {
 				throw new Exception("To use the 'balance' api method, you must specify a main password");
 			}
 		}

 		/**
 		 * Fetch the addresses of a wallet.
 		 * @return object Object containing the response.
 		 */
 		public function addresses() {
 			if( !is_null($this->mainPassword) ) {
 				$extras = array( "password" => $this->mainPassword );
 				return $this->merchantApiCall("list",$extras);
			} else {
 				throw new Exception("To use the 'addresses' api method, you must specify a main password");
 			}
 		}

 		/**
 		 * Gets the balance of a single address in the wallet
 		 * @param  string $address       Address to get balance of
 		 * @param  int $confirmations Minimum number of confirmations required
 		 * @return object                Object containing response.
 		 */
 		public function addressBalance($address, $confirmations = null) {
 			if( !is_null($this->mainPassword) ) {
 				
 				$extras = array( "password" => $this->mainPassword, "address" =>  $address );
 				if( !is_null($confirmations)) { $extras["confirmations"] = $confirmations; }

 				return $this->merchantApiCall("address_balance",$extras);
			
			} else {
 				throw new Exception("To use the 'addressBalance' api method, you must specify a main password");
 			}
 		}

 		/**
 		 * Create a new address
 		 * @param  string $label Human readable label/name for the address
 		 * @return object        Object containing response
 		 */
 		public function newAddress($label = null) {
 			if( !is_null($this->mainPassword) ) {
 				
 				$extras = array( "password" => $this->mainPassword );
 				if( !is_null($label)) { $extras["label"] = $label; }
 				if( !is_null($this->secondPassword)) { $extras["second_password"] = $this->secondPassword; }

 				return $this->merchantApiCall("new_address",$extras);
			
			} else {
 				throw new Exception("To use the 'newAddress' api method, you must specify a main password");
 			}
 		}

 		/**
 		 * Archive address
 		 * @param  string $address Address to archive
 		 * @return object          Object containing response
 		 */
 		public function archiveAddress($address) {
 			if( !is_null($this->mainPassword) ) {
 				
 				$extras = array( "password" => $this->mainPassword, "address" =>  $address );
 				if( !is_null($this->secondPassword)) { $extras["second_password"] = $this->secondPassword; }

 				return $this->merchantApiCall("archive_address",$extras);
			
			} else {
 				throw new Exception("To use the 'archiveAddress' api method, you must specify a main password");
 			}
 		}

 		/**
 		 * Unarchive an address
 		 * @param  string $address Address to unarchive
 		 * @return object          Object containing response
 		 */
 		public function unArchiveAddress($address) {
 			if( !is_null($this->mainPassword) ) {
 				
 				$extras = array( "password" => $this->mainPassword, "address" =>  $address );
 				if( !is_null($this->secondPassword)) { $extras["second_password"] = $this->secondPassword; }

 				return $this->merchantApiCall("unarchive_address",$extras);
			
			} else {
 				throw new Exception("To use the 'unArchiveAddress' api method, you must specify a main password");
 			}
 		}

 		/**
 		 * Remove some inactive archived addresses from the wallet and insert them as forwarding addresses.
 		 * @param  int $days Consolidate addresses which has not had any transactions in this many days
 		 * @return object       Object containing response
 		 */
 		public function consolidateAddresses($days) {
 			if( !is_null($this->mainPassword) ) {
 				
 				$extras = array( "password" => $this->mainPassword, "days" =>  $days );
 				if( !is_null($this->secondPassword)) { $extras["second_password"] = $this->secondPassword; }

 				return $this->merchantApiCall("auto_consolidate",$extras);
			
			} else {
 				throw new Exception("To use the 'consolidateAddresses' api method, you must specify a main password");
 			}
 		}
 		//URL methods
 		/**
 		 * Generate last steps of the url for the merchant API
 		 * @param  string $method         The method of the api to call
 		 * @param  array $parameterArray Array containing the http query variables
 		 * @return object                 Returns a json decoded object.
 		 */
 		public function merchantApiCall($method, $parameterArray) {
 			$url = $this->generateServiceUrl() . $method . '?' . http_build_query($parameterArray);
 			$return = json_decode( file_get_contents($url) );
 			if( is_object($return) ) {
 				return $return;
 			}

 			throw new Exception("Something went wrong.");
 		}

 		/**
 		 * Generates the last step of the url for the public API
 		 * @param  string $method         The method of the api to call
 		 * @param  array $parameterArray Array containing the http query variables
 		 * @return object                 Returns a json decoded object.
 		 */
 		public function apiCall($method, $parameterArray) {
 			$url = $this->apiUrl . $method . '?' . http_build_query($parameterArray);
 			$return = json_decode( file_get_contents($url) );
 			if( is_object($return) ) {
 				return $return;
 			}

 			throw new Exception("Something went wrong.");
 		}

 		/**
 		 * Generates a basic serviceurl to the api from the identifier and language values
 		 * @return string Generated url
 		 */
 		protected function generateServiceUrl() {
 			$this->generatedUrl = sprintf($this->merchantUrl,$this->language,$this->identifier);
 			return $this->generatedUrl;
 		}

 		/*Setters/Getters*/
 		/**
 		 * Gets or sets the language code. Supported languages are : sl, ro, it, tr, vi, no, hu, ko, hi, th, id, de, el, pl, pt, bg, sv, en, ru, es, nl, jp, da. 
 		 * @param  string $language empty to return current set language.
 		 * @return class           Returns the class
 		 */
 		public function language($language = null) {
 			if( !is_null($language) ) {
 				$this->language = $language;
 				return $this;
 			} else {
 				return $this->language;
 			}
 		}

 		/**
 		 * Sets your wallet identifier
 		 * @param  string $identifier The new identifier
 		 * @return class           Returns the class
 		 */
 		public function identifier($identifier) {
 				$this->identifier = $identifier;
 				return $this;
 		}

 		/**
 		 * Sets the second password if double-encryption is enabled
 		 * @param  string $password string containing the second password
 		 * @return class           Returns the class
 		 */
 		public function secondPassword($password) {
 			$this->secondPassword = $password;
 			return $this;
 		}


 		//*Converts*/
 		/**
 		 * Converts satoshi values to BTC currency.
 		 * @param  numeric $satoshi Numeric value containing the Satoshi
 		 * @return numeric          BTC value
 		 */
 		public function satoshiToBTC($satoshi) {
 			if( is_numeric($satoshi) ) {
 				return ( $satoshi/100000000 );
 			} else {
 				throw new Exception("The main satoshi amount to convert must be numeric.");
 			}
 		}

 		/**
 		 * Converts BTC currency to Satoshi values
 		 * @param numeric $BTC Numeric value containing the BTC amount
 		 * @return  numeric Satoshi value
 		 */
 		public function BTCToSatoshi($BTC) {
 			if( is_numeric($BTC) ) {
 				return ( $BTC*100000000 );
 			} else {
 				throw new Exception("The main BTC amount to convert must be numeric.");
 			}
 		}
	}

