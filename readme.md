## Instruction and docs.

**Directories details**

1) *assets* : Contain custom css and js
2) *Classes* : Contain all the php classes for project 
    * There are Two classes in this folder : 
    * Database  : To Make connection with database and handle database.
    * Universities : To handle search request.
3) *SQL* : which contains an files of sql database. i've imported database in different formate kinldy
    use any of them to store data in your database.

**Files details**

1) *Index.php* : Entery point of the application.


**Steps to run it**

1) Extract this in your server folder(Or configure virutal host its just choice).
2) open sql server and import data from /sql/.sql file.
2) change configuration of database from file: /Classes/Database.php @line:19 to 21
        > by default databse name is: pankaj,
        > by default databse user name is: root,
        > by default password is: "",
    save after changes.
4) Then open a browser and open your host in which these files exists and traverse to index.php.