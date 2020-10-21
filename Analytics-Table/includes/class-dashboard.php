<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class DashboardClass {
    public $wpdb;
    public $access;
    public $dtto;
    public $dtfrom;

    public function __construct($access) {
        // access id_user
        // 0 - admin
        // anotger manager
        global $wpdb;
        $this->wpdb=$wpdb;
        $this->access=$access;
        $this->setDate();
    }

    protected function setDate()
    {
        if(isset($_GET["dateto"]) && ($_GET["dateto"]!="") && isset($_GET["datefrom"]) && ($_GET["datefrom"]!="")) {
            if (strtotime($_GET["dateto"]) >= strtotime($_GET["datefrom"])) {
                $this->dtto = $_GET["dateto"];
                $this->dtfrom = $_GET["datefrom"];
            }
            else
            {
                $this->dtto = '';
                $this->dtfrom = '';
            }
        }
        else
        {
            $this->dtto = '';
            $this->dtfrom = '';
        }
    }

    // Берем всех пользователей админа
    protected function getAllUsersToAdmin()
    {
        return $this->wpdb->get_results( "SELECT distinct user_id FROM ".$this->wpdb->prefix."tg_user_mapping where m_status='Active' order by user_id");
    }

    // Берем всех пользователей менеджера
    protected function getAllManagerUsers()
    {
        return $this->wpdb->get_results( "SELECT student_id as user_id FROM ".$this->wpdb->prefix."tg_students_ids where manager_id=".$this->access);
    }

    // Берем все курсы пользователя
    protected function coursesByUserId($user_id)
    {
        $sqlAdd="";
        if ($this->dtto!="" && $this->dtfrom!="") $sqlAdd="and added_on between '".$this->dtfrom."' and '".$this->dtto." 23:59:59.999'";
        return $this->wpdb->get_results( "SELECT c_id, added_on FROM ".$this->wpdb->prefix."tg_user_mapping where m_status='Active' and user_id=".$user_id." ".$sqlAdd." order by user_id");
    }

    protected function lessonsByCourse($cours)
    {
        return $this->wpdb->get_results( "SELECT l_id FROM ".$this->wpdb->prefix."tg_lesson_mapping where m_type='lesson' and c_id=".$cours);
    }

    protected function getCompleatedLessonsByUser($user_id)
    {
        return $this->wpdb->get_results( "SELECT l_id FROM ".$this->wpdb->prefix."tg_user_lesson_complete_mapping where user_id=".$user_id );
    }

    // Выводим json с пользователями и курсами
    public function GetLessons()
    {
        if ($this->access==0) {$users=$this->getAllUsersToAdmin(); } else {$users=$this->getAllManagerUsers(); }
        $arraySbor=array();
        $i=0;
        // Пройдемся по пользователям
        foreach ($users as $user) {
            $user_id = $user->user_id;
            $user_data = get_user_by('id', $user_id);
            // Если пользователь по факту удален то не нужно продолжать
            if($user_data==null) continue;
            $user_name=$user_data->user_nicename;
            $user_email=$user_data->user_email;

            // Берем все курсы пользователя
            $courses = $this->coursesByUserId($user_id);
            // Оперативный массив подстановки данных в таблицу
            $lessArray=array();
            foreach ($courses as $cours) {
                //Проверяем не удален ли он случайно заодно берем название курса
                $post = get_post($cours->c_id);
                if ($post == null) continue;

                // Проверяем уроки и вводи их в массив
                $lessonsArray=array();
                $lessons= $this->lessonsByCourse($cours->c_id);
                foreach ($lessons as $lesson)
                {
                    $postLesson = get_post( $lesson->l_id );
                    if($postLesson==null) continue;
                    array_push($lessonsArray, ["l_id"=>$lesson->l_id, "l_name"=>$postLesson->post_title]);
                }
                $countLessons=count($lessonsArray);
                if ($countLessons!=0) {
                    $percentLesson = 100 / $countLessons;
                } else { $percentLesson=0; }
                // находим его курсы завершенные
                $compleateLessons = $this->getCompleatedLessonsByUser($user_id);
                $ix=0;
                foreach ($lessonsArray as $lessonSearch)
                {
                    foreach ($compleateLessons as $lessonCompl)
                    {
                        if ($lessonCompl->l_id==$lessonSearch["l_id"]) $ix++;
                    }
                }
                $percent=$percentLesson*$ix;
                array_push($lessArray, ['c_id'=>$cours->c_id, 'added_on'=>date("Y-m-d", strtotime($cours->added_on)), 'c_title'=>$post->post_title, 'percent'=>$percent]);
            }
            $i++;
            $arrP=array();
            foreach ($lessArray as $lesson)
            {
                $color="#ff5555";
                if (($lesson['percent']>50) && ($lesson['percent']<100)) $color="gold";
                if ($lesson['percent']==100) $color="#00bb00";
                array_push($arrP, ['color'=>$color, 'added_on'=>$lesson['added_on'], 'percent'=>$lesson['percent'], 'title'=>$lesson["c_title"]]);
            }
            array_push($arraySbor, ['i'=> $i, 'user_name'=> $user_name, 'user_email'=>$user_email, 'lessons'=>$arrP]);
        }
        return $arraySbor;
    }


    // Front
    public function ShowOutput(){
        $this->displayHeaderDashboard();
        echo '<div class="wrap">';
        $this->displayList();
        $this->showSearch();
        $this->showTableNavTop();
        $this->showAngulairTable();
        $this->showTableNavBottom();
        echo '</div>';
        }

    private function displayList()
    { ?>
        <ul class="subsubsub">
            <li class="all"><a href="#" class="current" aria-current="page">Все <span class="count">(4)</span></a> |</li>
            <li class="mine"><a href="#">Мои <span class="count">(1)</span></a> |</li>
            <li class="publish"><a href="#">Опубликованные <span class="count">(4)</span></a> |</li>
            <li class="trash"><a href="#">Корзина <span class="count">(3)</span></a></li>
        </ul>
        <?php
    }

    private function showSearch()
    { ?>
        <form id="posts-filter" method="get">
                <input type="hidden" name="page" value="analyticsTableDashboard_slug">
                <p class="search-box">
                    <input type="text" name="s1" style="width: 30px; padding: 0px; border: 0px; color: black;" value="from" disabled>
                    <input type="date" name="datefrom" value="<?php echo $this->dtfrom; ?>">
                    <input type="text" name="s2" style="width: 18px; padding: 0px; padding-left: 5px; border: 0px; color: black;" value="to" disabled>
                    <input type="date" name="dateto" value="<?php echo $this->dtto; ?>">
                    <input type="submit" id="search-submit" class="button" value="Search From-To Date">
                </p>
            </form>
      <?php
    }

    private function showActionsForm()
    { ?>
        <div class="alignleft actions bulkactions">
            <select name="action" id="bulk-action-selector-top">
                <option value="-1">Действия</option>
            </select>
            <input type="submit" id="doaction" class="button action" value="Применить">
        </div>
        <?php
    }

    private function showElementsCount()
    {
        ?>
        <div class="tablenav-pages one-page"><span class="displaying-num">4 элемента</span></div>
        <br class="clear">
        <?php
    }

    private function showFilter()
    {
        ?>
        <div class="alignleft actions">
            <select name="m" id="filter-by-date">
                <option selected="selected" value="0">Все даты</option>
                    <option value="202010">Октябрь 2020</option>
                    <option value="202007">Июль 2020</option>
            </select>
            <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Фильтр">
        </div>
        <?php
    }

    private function showTableNavTop()
    {
        ?>
        <div class="tablenav top">
            <?php
            $this->showActionsForm();
            $this->showFilter();
            $this->showElementsCount();
            ?>
        </div>
        <?php
    }

    private function showTableNavBottom()
    {
        ?>
        <div class="tablenav bottom">
            <?php
            $this->showActionsForm();
            $this->showElementsCount();
            ?>
        </div>
        <br class="clear">
        <?php
    }

    // Показать таблицу на ангуляре
    private function showAngulairTable()
    {
        ?>
                <table class="wp-list-table widefat fixed striped table-view-list posts">
                    <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column">
                            <input id="cb-select-all-1" type="checkbox"></td>
                        <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
                            <a href="#"><span>Заголовок</span><span class="sorting-indicator"></span></a>
                        </th>
                        <th scope="col" id="internal_name" class="manage-column column-internal_name">Internal Name</th>
                        <th scope="col" id="author" class="manage-column column-author">Автор</th>
                        <th scope="col" id="date" class="manage-column column-date sortable asc">
                            <a href="#"><span>Дата</span><span class="sorting-indicator"></span></a>
                        </th>
                        <th scope="col" id="courses" class="manage-column column-courses">Courses</th>
                        <th scope="col" id="members_enrolled" class="manage-column column-members_enrolled">Members Enrolled</th>
                        <th scope="col" id="members_unenrolled" class="manage-column column-members_unenrolled">Members Unenrolled</th>
                        <th scope="col" id="integrations" class="manage-column column-integrations">Integrations</th>
                    </tr>
                    </thead>

                    <tbody id="the-list">
                    <tr id="post-4052" class="iedit author-other level-0 post-4052 type-tg_access_mgmt status-publish hentry ast-col-sm-12 ast-article-post">
                        <th scope="row" class="check-column">			<label class="screen-reader-text" for="cb-select-4052">
                                Выбрать Access 1			</label>
                            <input id="cb-select-4052" type="checkbox" name="post[]" value="4052">
                            <div class="locked-indicator">
                                <span class="locked-indicator-icon" aria-hidden="true"></span>
                                <span class="screen-reader-text">
				“Access 1” заблокирована				</span>
                            </div>
                        </th>
                        <td class="title column-title has-row-actions column-primary page-title" data-colname="Заголовок"><div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
                            <strong><a class="row-title" href="https://project.t6767.kz/wp-admin/post.php?post=4052&amp;action=edit" aria-label="«Access 1» (Изменить)">Access 1</a></strong>
                            <div class="row-actions">
                                <span class="edit">
                                    <a href="https://project.t6767.kz/wp-admin/post.php?post=4052&amp;action=edit" aria-label="Редактировать «Access 1»">Изменить</a> | </span>
                                <span class="inline hide-if-no-js">
                                    <button type="button" class="button-link editinline" aria-label="Изменить свойства «Access 1»" aria-expanded="false">Свойства</button> |
                                </span>
                                <span class="trash">
                                    <a href="https://project.t6767.kz/wp-admin/post.php?post=4052&amp;action=trash&amp;_wpnonce=aa34af1a56" class="submitdelete" aria-label="Переместить «Access 1» в корзину">Удалить</a>
                                </span>
                            </div>
                            <button type="button" class="toggle-row">
                                <span class="screen-reader-text">Показать больше деталей</span>
                            </button>
                        </td>
                        <td class="internal_name column-internal_name" data-colname="Internal Name">Access 1</td><td class="author column-author" data-colname="Автор"><a href="https://project.t6767.kz/wp-admin/edit.php?post_type=tg_access_mgmt&amp;author=2">Avi</a></td><td class="date column-date" data-colname="Дата">Опубликовано<br>22.07.2020 в 11:38</td><td class="courses column-courses" data-colname="Courses">PHP<br>Software Testing Help<br></td><td class="members_enrolled column-members_enrolled" data-colname="Members Enrolled">2 members are assigned</td><td class="members_unenrolled column-members_unenrolled" data-colname="Members Unenrolled">talk.souvik@gmail.com<br></td><td class="integrations column-integrations" data-colname="Integrations"><strong>Digistore24</strong><br>Product ID 346252<br><strong>CopeCart</strong><br>Product ID 346252,345268<br></td>		</tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Выделить все</label><input id="cb-select-all-2" type="checkbox"></td><th scope="col" class="manage-column column-title column-primary sortable desc"><a href="https://project.t6767.kz/wp-admin/edit.php?post_type=tg_access_mgmt&amp;all_posts=1&amp;orderby=title&amp;order=asc"><span>Заголовок</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-internal_name">Internal Name</th><th scope="col" class="manage-column column-author">Автор</th><th scope="col" class="manage-column column-date sortable asc"><a href="https://project.t6767.kz/wp-admin/edit.php?post_type=tg_access_mgmt&amp;all_posts=1&amp;orderby=date&amp;order=desc"><span>Дата</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-courses">Courses</th><th scope="col" class="manage-column column-members_enrolled">Members Enrolled</th><th scope="col" class="manage-column column-members_unenrolled">Members Unenrolled</th><th scope="col" class="manage-column column-integrations">Integrations</th>	</tr>
                    </tfoot>
                </table>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <div ng-app="myApp" ng-controller="namesCtrl">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col" ng-click="orderByMe('i')">#</th>
                    <th scope="col" ng-click="orderByMe('user_name')">Name</th>
                    <th scope="col" ng-click="orderByMe('user_email')">Email</th>
                    <th scope="col" ng-click="orderByMe('lessons')">Cources / Date</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row"> <input type="text" ng-model="iserach" style="width: 30px;"></th>
                    <td><input type="text" ng-model="name_user"></td>
                    <td><input type="text" ng-model="email"></td>
                    <td><input type="text" ng-model="les"> / <input type="text" ng-model="dat"></td>
                    <td></td>
                </tr>
                <tr ng-repeat="x in blocks | orderBy:myOrderBy | filter : {'i': iserach, 'user_name': name_user, 'user_email': email, lessons: { title: les, added_on: dat } }">
                    <th scope="row">{{x.i}}</th>
                    <td>{{x.user_name}}</td>
                    <td>{{x.user_email}}</td>
                    <td>
                        <table style="width: 100%;">
                        <tr>
                        <tr  ng-repeat="lesson in x.lessons  | filter : {title: les, added_on: dat }" style="background: {{lesson.color}}">
                                <td style="width: 50%;">{{lesson.title}}</td>
                                <td>{{lesson.percent}}%</td>
                                <td>{{lesson.added_on}}</td>
                        </tr>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <script>
            angular.module('myApp', []).controller('namesCtrl', function($scope) {
                $scope.orderByMe = function(x) {
                    $scope.myOrderBy = x;
                    console.log(x);
                };
                $scope.blocks=<?php echo json_encode($this->GetLessons()); ?>;
            });
        </script>
        <?php
    }


    // Выводит верх страницы
    private function displayHeaderDashboard()
    {
        ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <div class="wrap">
            <h1 style="font-size: 3em; font-weight: 600;"><?php echo get_admin_page_title() ?></h1>
        </div>
        <?php
    }

}
