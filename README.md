Blockchain-php
==============
JonasMe

jonas@mersholm.dk

Donations are greatly appreciated at : 1E4FU9CErrDatuHojDoudEuqjSadB1sRaJ


---------





This is a Php class aimed at serving easy to use, out of the box API acces to the Blockchain API's (Both Merchant and public api)





### Ready the class
```php
  require_once( "blockchainPhp.php" );
  $api = new BlockchainPhp("blockchain-identifier","password");
```
**The constructor takes the following arguments**

| Argument        | required         |
| ------------- |:-------------:|
| identifier      | yes | 
| main password      | no      |  
| second password | no      |     





### Getters and setters
You may set or get the language at any time
```php
    $api->language("ru");
    print $api->language();
```

You may set the identifier at any time
```php
    $api->identifier("new-identifier");
```

You may set a secondary password at any time, if double-encryption is enabled
```php
    $api->secondPassword("Your second password");
```





### Helper methods
You may convert Satoshi to BTC currency
```php
    print $api->satoshiToBTC(19283829); //Result 0.19283829
```

You may convert BTC to Satoshi currency
```php
    print $api->BTCToSatoshi(0.19283829); //Result 19283829
```





### Generating Receiving Addresses
https://blockchain.info/da/api/api_receive

Its now as easy as this, to generate a reciving address
```php
    try {
      $response = $api->generateReceiveToken("1E4FU9CErrDatuHojDoudEuqjSadB1sRaJ","http://callback.url");
      print "Pay to " . $response->input_address;
    } catch(Exception $e) {}
```
**The generateReceiveToken method takes the following arguments**

| Argument        | required         |
| ------------- |:-------------:|
| address      | yes | 
| callback url      | yes      |  





### Making Outgoing Payments
https://blockchain.info/da/api/blockchain_wallet_api

You may send a payment using the following method
```php
    try {
      $response = $api->pay("1E4FU9CErrDatuHojDoudEuqjSadB1sRaJ",1.1 );
    } catch(Exception $e) {}
```
**The pay method takes the following arguments**

| Argument        | required         | description         |
| ------------- |:-------------:|:-------------:|
| recipient      | yes | Address of recipient |
| amount      | yes      |  Amount in bitcoins to send |
| extras      | no      |  array containing extra parameters |





### Fetching the wallet balance
https://blockchain.info/da/api/blockchain_wallet_api

You may fetch your wallets balance this way
```php
    try {
      $response = $api->balance();
      print $api->satoshiToBTC( $response->balance );
    } catch(Exception $e) {}
```
**The balance method takes no arguments**





### Listing Addresses
https://blockchain.info/da/api/blockchain_wallet_api

You may list all your addresses this way
```php
    try {
      $response = $api->addresses();
    } catch(Exception $e) {}
```





### Getting the balance of an address
https://blockchain.info/da/api/blockchain_wallet_api

Get the balance of a single address
```php
    try {
      $response = $api->addressBalance("1E4FU9CErrDatuHojDoudEuqjSadB1sRaJ");
      print $api->satoshiToBTC( $response->balance );
    } catch(Exception $e) {}
```
**The addressBalance method takes the following arguments**

| Argument        | required         | description         |
| ------------- |:-------------:|:-------------:|
| address      | yes | Address to check balance of |
| confirmations      | no      |  Minimum number of confirmations required |





### Generating a new address
https://blockchain.info/da/api/blockchain_wallet_api

Create a new address
```php
    try {
      $response = $api->newAddress("My new address");
    } catch(Exception $e) {}
```
**The newAddress method takes the following argument**

| Argument        | required         | description         |
| ------------- |:-------------:|:-------------:|
| label      | no | Give your address a human readable name |





### Archiving an address
https://blockchain.info/da/api/blockchain_wallet_api

Archive an address
```php
    try {
      $response = $api->archiveAddress("1E4FU9CErrDatuHojDoudEuqjSadB1sRaJ");
    } catch(Exception $e) {}
```
**The archiveAddress method takes the following argument**

| Argument        | required         | description         |
| ------------- |:-------------:|:-------------:|
| address      | yes | Address to archive |





### Unarchiving an address
https://blockchain.info/da/api/blockchain_wallet_api

Unarchive an address
```php
    try {
      $response = $api->unArchiveAddress("1E4FU9CErrDatuHojDoudEuqjSadB1sRaJ");
    } catch(Exception $e) {}
```
**The unArchiveAddress method takes the following argument**

| Argument        | required         | description         |
| ------------- |:-------------:|:-------------:|
| address      | yes | Address to archive |





### Consolidating Addresses
https://blockchain.info/da/api/blockchain_wallet_api

Unarchive an address
```php
    try {
      $response = $api->consolidateAddresses(10);
    } catch(Exception $e) {}
```
**The consolidateAddresses method takes the following argument**

| Argument        | required         | description         |
| ------------- |:-------------:|:-------------:|
| days      | no | Consolidate addresses which has not had any transactions in this many days |





----





**Thank you for reading/using**

**JonasMe**





Donations are greatly appreciated at : 1E4FU9CErrDatuHojDoudEuqjSadB1sRaJ
