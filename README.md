## Calculate the commission service

In this system I wrote a service for display commission of (Deposit, Withdraw) and I used “Chain of Responsibility” and implement this Design pattern with one interface and one abstract class and some class I needed form calculating commission such as Deposite , Withdraw and I used “Singleton” for call this api.exchangeratesapi.io and set currencies we want … also I used two trait for preparing data from csv file and calculating repetitive function of classes. 
All of settings for this service is in “config/payment.php” and you can change all of them for example you can add or remove currencies in there or increase and decrease percent operation types.

for executing this service it's enough you do these:
-	Command to run “php artisan run:service”
-	Command to run test “php artisan test”

## Docker image


## Design patterns:
- Chain of Responsibility
- Singleton

## Project’s files:
1.	PaymentHandlerService.php 		in “app/Services/PaymentHandler/”.
2.	PaymentHandler.php                            in “app/Services/PaymentHandler /Interfaces/”.
3.	AbstractPaymentHandler.php	in “app/Services/PaymentHandler /Classes/”.
4.	DepositeHandler.php			in “app/Services/PaymentHandler /Classes/”
5.	WithdrawHandler.php		in “app/Services/PaymentHandler /Classes/”
6.	CurrencyHandler.php			in “app/Services/PaymentHandler /Classes/”
7.	FileHandler.php			in “app/Services/PaymentHandler /Traits/”
8.	PaymentHandler.php			in “app/Services/PaymentHandler /Traits/”
9.	RunService.php			in “app/Console/Commands/”
10.	CommissionTest.php			in “tests/Unit/”
11.	payment.php				in “config/”
12.	payment.csv				in “storage/files/”




