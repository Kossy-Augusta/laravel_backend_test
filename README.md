LARAVEL BACKEND TECHNICAL TEST

TASK: Design and develop a USER-PRODUCT system.

The above system should be developed using Laravel and MYSQL storage system and should also consider protection against SQL injection wherever possible.

Tech Stacks: PHP/Laravel.
Frameworks: Sql/Eloquent for laravel
Storage:  MySQL

TASK DETAILS
1. A user can create an account, login to their dashboard, and reset their forgotten password. This authentication system should be a tokenized system that will expire at a certain time range.

2. A user can have many products and many products can only belong to one user demonstrating proper use of ( one-to-many )relationships.

3. Products can belong to many categories and a category can have many products and only authorized user can perform CRUD operation on the categories (many-to-many relationship)

4. Users products should have [ NAME, DESCRIPTION, QUANTITY, UNIT PRICE, AMOUNT_SOLD etc ] as attributes. ( Use appropriate dataType for all fields )

5. Products can be updated and deleted by the owner. A user is not allowed to update or delete products that don't belong to them.

6. Users should be listed with their Products in a DESC order

7. Products should be listed with pagination and in DESC order.

8. Products can be searched

8. An API that returns the general statistics of all the data on the system.

9. Create a github Repository and push your code and share this repository when done.

10. Demonstrate proper documentation standards by documenting your APIs using postman.

