# PlayerDataWebsitePMMP
A specific website to make a stats website for pocketmine
**Warning:**
this is just a basic example of how our regular pocketmine websites get stats
but this is a bit weeker and bad
This is used using PHP & Mysql if not working in the feature it will also be helped using PDO
# Preview
TesterMain.php
![MainPic](https://github.com/ItsToxicGG/PlayerDataWebsitePMMP/blob/main/images/main.png?raw=true)

TesterLogin.php
![LoginPic](https://github.com/ItsToxicGG/PlayerDataWebsitePMMP/blob/main/images/login.png?raw=true)

TesterRegister.php
![RegisterPic](https://github.com/ItsToxicGG/PlayerDataWebsitePMMP/blob/main/images/register.png?raw=true)

Stats.php
![StatsPIC](https://github.com/ItsToxicGG/PlayerDataWebsitePMMP/blob/main/images/stats.png?raw=true)
# Other
The Mysql Table is created in the Plugin (playerlyAPI)
# Features
- [X] Supports Mysql (could do nothing without it)
- [X] Login & Register System (to get stats from the name given)
- [X] Stats from in game
- [ ] PDO (mabye:/ if it aint working good)
- [ ] Microsoft Login (rather login and enter username, login using Microsoft and gets the name of the Microsoft account)
- [ ] Player Skin shown by stats (by name)
# Tester
The Tester is a series of files for testing login system
- Testerdb (testerdb, is where the database connection is taking place for all other testerfiles)
- TesterLogin (testerlogin, is where you have to login if you already made an account)
- TesterMain (testermain, the main section of tester, you can access reset or unlogin also beta stats (get player stats by the username that have set in login) or stats (get only one player stat which is the one selected in the string, if does not exist or some type of error has occur it will return N/A))
- TesterRegister (If you dont have an account you can make one in TesterRegister)
- TesterRestPassword (Reset your password if you want to access that account somewhere else but forgot the password) 
- TesterUnlogin (Logs you out from your account)
# How to use
1. Change Mysql details in api.php
2. use PlayerlyAPI (has mostly everything you need) (plugin by me)
3. change the css and stuff as you wish.
# Open-Source
This is a open-source website so feel free to edit what ever u want.
# Donate
Support me by sending any amount of money, this will also help me to keep on working
on this project & improve it
