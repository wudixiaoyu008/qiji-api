<?php
$api = app('Dingo\Api\Routing\Router');


$api->version('v1.0', ['namespace' => 'App\Http\V1_0\Controllers'], function($api) {

  $api->get('test', 'ApiTestController@test');                                                 // 测试项目是否运行成功

  $api->post('captcha/send/mobile', 'Auth\CaptchaController@sendToMobile');                    //  给手机发送验证码
  $api->post('login/mobile', 'Auth\LoginController@mobile');                                   //  手机登录
  $api->post('login/wechat', 'Auth\LoginController@wechat');                                   //  微信登录

  $api->get('classes', 'ClassesController@index');                                             //  获取班级列表
  $api->get('classes/registration_rules', 'ClassesController@registrationRules');              //  返回班级报名规则
  $api->get('classes/renewal_rules', 'classesController@renewalRules');                        //  返回班级报名规则(续费)
  $api->get('classes/{class_id}/current_mentees', 'MenteeController@getCurrentMentees');       //  获取班级当前学员
  $api->get('classes/{class_id}/exited_mentees', 'MenteeController@getExitedMentees');         //  获取班级结业学员
  $api->get('classes/{class_id}', 'ClassesController@show');                                   //  获取班级详情
  $api->get('classes/{class_id}/intro', 'ClassesController@showIntro');                        //  获取班级简介页面

  $api->post('alipay/notify', 'AliPayController@notify');                                      //  支付宝异步通知
  $api->post('alipay/return', 'AliPayController@AlipayReturn');                                //  支付宝同步通知

  // 需提供 JWT
  $api->group(['middleware' => 'jwt.auth', 'providers' => 'jwt'], function($api) {

    $api->get('jobs', 'JobController@index');                                                //  获取职位信息
    $api->get('areas', 'AreaController@index');                                              //  获取区域信息
    $api->get('tech_categories', 'TechCategoryController@index');                            //  技术分类列表
    $api->post('learn_things', 'LearnThingController@store');                                //  添加想学
    $api->post('alipay', 'AliPayController@pay');                                            //  支付宝支付

    $api->get('users/{id}', 'UserInfoController@show');                                      //  获取用户个人信息
    $api->get('course/{id}', 'CourseController@show');                                       //  获取课堂的详情
    $api->get('courses', 'CourseController@index');                                          //  获取课堂列表

    $api->get('my/classes', 'MyController@classes');                                         //  获取我的班级
    $api->get('my/articles', 'MyController@articles');                                       //  个人技术文章列表
    $api->get('my/courses', 'MyController@courses');                                         //  获取我的课堂
    $api->get('my/mentees', 'MyController@mentees');                                         //  获取我的课堂
    $api->get('my/tech_stars/{tech_category_id}', 'MyController@techStars');                 //  个人奇迹技术星列表
    $api->get('my/uncomment/tasks', 'TaskController@unCommentTask');

    $api->post('tasks/{task_id}/comments', 'TaskController@evaluateTask');                   //  评价任务
    $api->get('tasks/{task_id}/comments', 'TaskController@index');                           //  获取任务评论列表

    $api->get('resumes', 'ResumeController@index');                                          //  获取人才简历列表
    $api->get('resumes/{id}', 'ResumeController@show');                                      //  获取人才简历详情

    $api->post('articles/nohelps/{article_id}', 'ArticleController@changeNohelps');          //  增加和删除没有帮助标记
    $api->get('articles/{article_id}/thanks', 'ArticleThanksController@thanks');             //  技术文章感谢/取消感谢
    $api->get('articles/{article_id}', 'ArticleController@show');                            //  获取技术文章详情

    $api->post('answers/collections/{answer_id}', 'QuestionController@toggleCollection'); //收藏/取消收藏答案
  });
});

