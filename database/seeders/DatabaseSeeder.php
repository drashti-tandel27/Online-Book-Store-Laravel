<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            'Fiction', 'Non-Fiction', 'Science', 'Technology',
            'Business', 'Self-Help', 'Biography', 'History'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => strtolower(str_replace(' ', '-', $category)),
                'description' => "Books in {$category} category"
            ]);
        }

        $this->command->info('Categories created successfully!');

        // Create Books
        $books = [
            [
                'title' => 'Rich Dad Poor Dad',
                'author' => 'Robert Kiyosaki',
                'description' => 'Master the mindset of financial independence. What the rich teach their kids about money that the poor and middle class do not!',
                'price' => 15.99,
                'stock' => 50,
                'isbn' => '9781612680194',
                'category' => 'Business',
                'pages' => 336,
                'publisher' => 'Plata Publishing',
                'publication_year' => 2017
            ],
            [
                'title' => 'Ikigai',
                'author' => 'Héctor García',
                'description' => 'The Japanese secret to a long and happy life. Discover the Japanese concept of ikigai and find your purpose.',
                'price' => 14.99,
                'stock' => 45,
                'isbn' => '9780143130727',
                'category' => 'Self-Help',
                'pages' => 208,
                'publisher' => 'Penguin Books',
                'publication_year' => 2017
            ],
            [
                'title' => 'The Alchemist',
                'author' => 'Paulo Coelho',
                'description' => 'A magical journey of dreams and destiny. Follow Santiago on his journey to discover his personal legend.',
                'price' => 13.99,
                'stock' => 60,
                'isbn' => '9780062502174',
                'category' => 'Fiction',
                'pages' => 208,
                'publisher' => 'HarperOne',
                'publication_year' => 1993
            ],
            [
                'title' => 'Attitude is Everything',
                'author' => 'Jeff Keller',
                'description' => 'Harness the power of a positive mindset. Change your attitude and change your life.',
                'price' => 12.99,
                'stock' => 40,
                'isbn' => '9780062572030',
                'category' => 'Self-Help',
                'pages' => 144,
                'publisher' => 'HarperCollins',
                'publication_year' => 2015
            ],
            [
                'title' => 'Think and Grow Rich',
                'author' => 'Napoleon Hill',
                'description' => 'Unlock the principles of success and wealth. The timeless classic on personal success.',
                'price' => 11.99,
                'stock' => 55,
                'isbn' => '9781585424337',
                'category' => 'Business',
                'pages' => 320,
                'publisher' => 'TarcherPerigee',
                'publication_year' => 1937
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'description' => 'An easy and proven way to build good habits and break bad ones.',
                'price' => 16.99,
                'stock' => 70,
                'isbn' => '9780735211292',
                'category' => 'Self-Help',
                'pages' => 320,
                'publisher' => 'Avery',
                'publication_year' => 2018
            ],
            [
                'title' => 'The 7 Habits of Highly Effective People',
                'author' => 'Stephen R. Covey',
                'description' => 'Powerful lessons in personal change.',
                'price' => 17.99,
                'stock' => 35,
                'isbn' => '9781982137274',
                'category' => 'Self-Help',
                'pages' => 432,
                'publisher' => 'Simon & Schuster',
                'publication_year' => 2020
            ],
            [
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'description' => 'A brief history of humankind.',
                'price' => 19.99,
                'stock' => 30,
                'isbn' => '9780062316097',
                'category' => 'History',
                'pages' => 464,
                'publisher' => 'Harper',
                'publication_year' => 2015
            ]
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        $this->command->info('Books created successfully!');

        // Create or Update Admin User
        $admin = User::where('email', 'admin@bookstore.com')->first();
        
        if ($admin) {
            // Update existing admin
            $admin->update([
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'phone' => '+1234567890',
                'address' => '123 Admin St, Book City, BC 12345',
                'is_admin' => true,
            ]);
            $this->command->info('Admin user updated successfully!');
        } else {
            // Create new admin
            User::create([
                'name' => 'Admin ',
                'email' => 'admin@bookstore.com',
                'password' => bcrypt('password'),
                'phone' => '+1234567890',
                'address' => '123 Admin St, Book City, BC 12345',
                'is_admin' => true,
            ]);
            $this->command->info('Admin user created successfully!');
        }
    }
}