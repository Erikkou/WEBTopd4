<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Customer;
use App\Entity\LoanStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customer1 = new Customer();
        $customer1->setName('John Doe');
        $customer1->setEmail('john@example.com');
        $manager->persist($customer1);

        $customer2 = new Customer();
        $customer2->setName('Jane Smith');
        $customer2->setEmail('jane@example.com');
        $manager->persist($customer2);

        $customer3 = new Customer();
        $customer3->setName('Alice Johnson');
        $customer3->setEmail('alice@example.com');
        $manager->persist($customer3);

        $author1 = new Author();
        $author1->setName('J.K. Rowling');
        $manager->persist($author1);

        $author2 = new Author();
        $author2->setName('J.R.R. Tolkien');
        $manager->persist($author2);

        $author3 = new Author();
        $author3->setName('George R.R. Martin');
        $manager->persist($author3);

        $loanStatus1 = new LoanStatus();
        $loanStatus1->setStatus('Checked out');
        $manager->persist($loanStatus1);

        $loanStatus2 = new LoanStatus();
        $loanStatus2->setStatus('Available');
        $manager->persist($loanStatus2);

        $book1 = new Book();
        $book1->setTitle('Harry Potter and the Sorcerer\'s Stone');
        $book1->setAuthorID($author1);
        $book1->setLoanID($loanStatus1);
        $book1->setCustomerID($customer1);
        $manager->persist($book1);

        $book2 = new Book();
        $book2->setTitle('The Hobbit');
        $book2->setAuthorID($author2);
        $book2->setLoanID($loanStatus1);
        $book2->setCustomerID($customer2);
        $manager->persist($book2);

        $book3 = new Book();
        $book3->setTitle('A Game of Thrones');
        $book3->setAuthorID($author3);
        $book3->setLoanID($loanStatus2);
        $manager->persist($book3);



        $manager->flush();
    }
}

