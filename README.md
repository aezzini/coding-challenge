#  Coding Challenge Software Engineer application by Ayoub EZZINI
Contest description:
https://github.com/NextmediaMa/coding-challenges/tree/master/Junior%20Software%20Engineer

## Requirements
- PHP >7.3
- NodeJS >12
- Composer

## Installation Guide
1. Create `.env` file based on `.env.example`.
2. Install composer packages using `composer install`
3. Install npm packages using `npm install`
4. Initialize the database schema using `php artisan migrate`
5. Init Category seeder `php artisan db:seed --class=CategorySeeder`
6. Init Product seeder `php artisan db:seed --class=ProductSeeder`
7. Start the application `php artisan serve`
8. Use `npm run watch` if needed

## Custom Commands
- Create category `php artisan create:category`
- Create product `php artisan create:product`
- Make Repository `php artisan make:repository`
- Make Service `php artisan make:service`

## Service Layer
- Service Layer is a list of service classes that are used to handle application logic
- The service layer namespace is `App/Service`
- The common callable functions are listed in the `AbstractService`
- Every service layer extends from the `AbstractService`

## Repository Layer
- A repository represents an architectural layer that handles communication between the application and data source
- The service layer namespace is `App/Repository`
- The common callable functions are listed in the `AbstractRepository`
- Every repository layer extends from the `AbstractRepository`

## Unit Test
- The category and product controller Unit Tests are listed on `Tests\Unit`

## Gallery
- Product List
![Product List](https://i.ibb.co/jrKh2T7/Product-List.jpg)

- Product Form
![Product Form](https://i.ibb.co/7nRxrWv/Product-Form.jpg)

- Category List
![Category List](https://i.ibb.co/XkCGzdJ/Category-List.jpg)

- Category Form
![Category Form](https://i.ibb.co/syfc5P1/Category-Form.jpg)

- Create Product Command Line
![Create Product Command Line](https://i.ibb.co/PWRSrMt/Create-Product.jpg)

- Create Category Command Line
![Create Category Command Line](https://i.ibb.co/nn0hNY2/Create-Category.jpg)

- Create Category Command Line
![Create Category Command Line](https://i.ibb.co/nn0hNY2/Create-Category.jpg)

- Make Service Command Line
![Make Service Command Line](https://i.ibb.co/1QWym7C/Make-Service.jpg)

- Make Repository Command Line
![Make Repository Command Line](https://i.ibb.co/sP4FqzS/Make-Repository.jpg)

- Unit Test
![Unit Test](https://i.ibb.co/zSpVvTr/UnitTest.jpg)




Regards. 
Ayoub
