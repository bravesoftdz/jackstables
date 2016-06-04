# Welcome to Jack's Table Emporium

## Installation
1. Set up apache to serve the public_html folder
2. ci/application/db and ci/application/db/jackstables.sqlite3 should have write permissions: db folder should look something like this and have write and execute permissions: ```drwxrwxr--  2 root www-data  4096 Jun  4 16:03 .```
  and jackstables.sqlite3 should look something like this: ```-rwxrw-r--  1 root www-data 11264 Jun  4 16:03 jackstables.sqlite3``` Becuase the group is www-data (which is webserver) and group has write permissions
3. public_html/images/products should have write permissions
  ```cd public_html/images/products```
  ```chmod a+w .```
4. Go to ci/application/config/config.php and change $config['base_url'] = 'http://jackstables.dev:8042/'; to the correct base url of the website include trailing slash
5. Go to ci/application/config/my_extra_config.php and change the email address of where to receive the comments
6. The admin portion of the website is in /admin and the user is admin password 123

## Review
1. To not get confused, there is codeigniter code and then there is my code. 
2. My Code is in ci/application/views/, ci/application/controllers/ , ci/application/models , ci/application/config/my_extra_config.php , ci/application/config/routes.php
3. The database and schema are located in ci/application/db
4. Also there is some code in public_html/css and js

## Additional Comments/Improvements
- Database should be MySQL since it is more strict with the data types, but sqlite was chosen for simplicity and small number of rows
- There should be a way to add multiple picture uploads, for example another table product_image pid image name
- There could be more product details such as pricing if we were to go with e-commerce and a shopping cart mechanism
- The admin page should have different user types and privileges such as add/delete/edit/view 
- The password should be hashed using PHP's password_hash() for the admin page and there should be a way to add admin users and change password etc.
- Ideally I would of been much more generic with everything instead of "Jack's Tables" but because this is going to be a fetch-and-go type of deal with minimal to no setup required, I just wanted to include all the configuration and database right in the project for that sake only.
- We could add pagination to admin/products and products page
- Category could be its own table and have a description, etc
- We could use ajax to spice it up a bit (removing, inline editing, etc)
- Image uploads should resize the image so it is not too big/highres
- In Admin/products/view we could utilize sorting by columns to make it easier to find products
- Also we could have a search box to quickly find a product

## Original Description:

Your boss hands you a set of requirements for Jack’s Table Emporium’s new website. This website should contain a home page which showcases their various products. There should be three supporting product pages: one for tables, one for chairs and one for table accessories. Finally, there should be a contact form. The contact form should validate that the proper fields are completed and send the form via email to the site owner.
There should also be an admin section that allows the site owner to log in and adjust the contents of each of the three product pages. The pages should allow an unlimited number of types of product (think of each individual page as a ‘category’ for the product). The owner should be able to add / edit / remove products at will. Additionally, each product should have an inventory count with it that can also be adjusted. Changes applied in the admin section should appear immediately on the public facing portions of the site.


