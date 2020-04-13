<?php

use App\User;
use App\Role;
use App\Category;
use App\Question;
use App\Answer;
use App\Reputation;
use App\Rate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call('RoleSeeder');
        $this->call('UserTableSeeder');
        $this->call('CategoriesSeeder');
        $this->call('QuestionsSeeder');
        $this->call('AnswersSeeder');
        $this->call('ReputationSeeder');
        $this->call('RateSeeder');
    }
}

class RoleSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        Role::create(array(
            'name' => 'user'
        ));
        Role::create(array(
            'name' => 'admin'
        ));
    }

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'name' => 'zwedge',
            'email' => 'zwedge@know.fr',
            'password' => bcrypt('knowledgeradmin'),
            'role_id' => '1'
        ));

        User::create(array(
            'name' => 'test',
            'email' => 'test@test.fr',
            'password' => bcrypt('123456'),
            'role_id' => '1'
        ));
    }
}

class CategoriesSeeder extends Seeder {

    public function run()
    {
        DB::table('categories')->delete();

        $list_car = array(
            'Atronomie','Cuisine','Sport','Education','Chimie','Géographie'
        );

        foreach ($list_car as $item){
            Category::create(array(
                'name' => $item
            ));
        }

    }

}
class QuestionsSeeder extends Seeder {

    public function run()
    {
        DB::table('questions')->delete();

        Question::create(array(
            'content' => 'Comment préparer une tarte aux pommes ?',
            'user_id' => 1,
            'category_id' => 2
        ));
        Question::create(array(
            'content' => 'Comment faire du sulfate de cuivre ?',
            'user_id' => 2,
            'category_id' => 5
        ));
    }
}
class AnswersSeeder extends Seeder {

    public function run()
    {
        DB::table('answers')->delete();

        Answer::create(array(
            'content' => 'Apprends juste à cuisiner',
            'user_id' => 2,
            'question_id' => 1
        ));
        Answer::create(array(
            'content' => 'Aucune idée',
            'user_id' => 1,
            'question_id' => 2
        ));
    }
}
class ReputationSeeder extends Seeder {

    public function run()
    {
        DB::table('reputations')->delete();

        Reputation::create(array(
            'value' => 105,
            'user_id' => 1,
            'category_id' => 2
        ));
        Reputation::create(array(
            'value' => 10,
            'user_id' => 2,
            'category_id' => 2
        ));
        Reputation::create(array(
            'value' => 10,
            'user_id' => 2,
            'category_id' => 3
        ));
    }
}

class RateSeeder extends Seeder {

    public function run()
    {
        DB::table('rates')->delete();

        Rate::create(array(
            'type' => 'up',
            'user_id' => 1,
            'answer_id' => 1
        ));
    }
}
