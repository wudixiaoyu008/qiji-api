<?php namespace App\Providers;

use App\Repositories\AreaRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleThanksRepository;
use App\Repositories\AuthCodeRepository;
use App\Repositories\ClassCommentRepository;
use App\Repositories\ClassesRepository;
use App\Repositories\ClassMenteesRepository;
use App\Repositories\CourseRepository;
use App\Repositories\Interfaces\AreaInterface;
use App\Repositories\Interfaces\ArticleInterface;
use App\Repositories\Interfaces\ArticleThanksInterface;
use App\Repositories\Interfaces\AuthCodeInterface;
use App\Repositories\Interfaces\ClassCommentInterface;
use App\Repositories\Interfaces\ClassesInterface;
use App\Repositories\Interfaces\ClassMenteesInterface;
use App\Repositories\Interfaces\CourseInterface;
use App\Repositories\Interfaces\JobInterface;
use App\Repositories\Interfaces\LearnThingInterface;
use App\Repositories\Interfaces\MyInterface;
use App\Repositories\Interfaces\PaymentInterface;
use App\Repositories\Interfaces\QuestionInterface;
use App\Repositories\Interfaces\TaskInterface;
use App\Repositories\Interfaces\TechCategoryInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\JobRepository;
use App\Repositories\LearnThingRepository;
use App\Repositories\MyRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TechCategoryRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ResumeInterface;
use App\Repositories\ResumeRepository;

class AppServiceProvider extends ServiceProvider {

  /**
   * Register any application services.
   * @return void
   */
  public function register()
  {
    $this->app->bind(UserInterface::class, UserRepository::class);
    $this->app->bind(AuthCodeInterface::class, AuthCodeRepository::class);
    $this->app->bind(TechCategoryInterface::class, TechCategoryRepository::class);
    $this->app->bind(JobInterface::class, JobRepository::class);
    $this->app->bind(ClassesInterface::class, ClassesRepository::class);
    $this->app->bind(ClassCommentInterface::class, ClassCommentRepository::class);
    $this->app->bind(AreaInterface::class, AreaRepository::class);
    $this->app->bind(ClassMenteesInterface::class, ClassMenteesRepository::class);
    $this->app->bind(LearnThingInterface::class, LearnThingRepository::class);
    $this->app->bind(CourseInterface::class, CourseRepository::class);
    $this->app->bind(ResumeInterface::class, ResumeRepository::class);
    $this->app->bind(MyInterface::class, MyRepository::class);
    $this->app->bind(ArticleThanksInterface::class, ArticleThanksRepository::class);
    $this->app->bind(TaskInterface::class, TaskRepository::class);
    $this->app->bind(ArticleInterface::class, ArticleRepository::class);
    $this->app->bind(PaymentInterface::class, PaymentRepository::class);
    $this->app->bind(QuestionInterface::class, QuestionRepository::class);
  }
}
