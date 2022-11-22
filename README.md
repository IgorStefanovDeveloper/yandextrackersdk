<h1>SDK для Yandex Tracker</h1>

https://packagist.org/packages/localtests/yandextrackersdk

Для устновки sdk необходимо выполнить в терминале следующие команды:

1) composer update
2) composer require localtests/yandextrackersdk dev-main

<h2>Создание экзампляра класса Tracker</h2>
Для работы с API Яндекс Трекера вам необходимо получить токен авторизации и id организации.
Подробнее об их получании можно почитать <a href="https://yandex.ru/dev/connect/tracker/api/about.html">тут</a>.
<pre>
$token = getenv('API_TOKEN');
$orgId = getenv('ORG_ID');

$tracker = new Tracker($token, $orgId);
</pre>

<h2>Работа с задачами</h2>
<h3>Получание списка задач</h3>
<pre>
$queueKey = getenv('QUEUE_KEY'); // индефикатор очереди
$perPage = '10'; // пагинация, количество задач на странице
$page = '1'; // пагинация, текущая страница.

//В переменную $tasks вы получите массив задач Localtests\Yandextrackersdk\Task\Task
$tasks = $tracker->taskManager->findTask($queueKey, $perPage, $page);

foreach($tasks as $task){
    echo $task->getSummery();
    echo $task->getDescription();
}
</pre>

<h3>Получание задачи по ключу</h3>
<pre>
$issueKey = getenv('ISSUE_KEY'); // индефикатор очереди
//В переменную $task вы получите экземпляр класс Localtests\Yandextrackersdk\Task\Task
$task = $tracker->taskManager->getTaskObjByKey($issueKey);
echo $task->getSummery();
echo $task->getDescription();
</pre>
<h3>Изменение задачи</h3>
<pre>
$task->setSummery('Новое название задачи');
$task->setDescription('Новое описание задачи');
$this->taskManager->editTaskObj($task);
</pre>
<h3>Создание задачи</h3>
<pre>
$assignee = new Employee(['id' => getenv('EMPLOYEE_ID'), 'self' => getenv('EMPLOYEE_SELF'), 'display' => getenv('EMPLOYEE_DISPLAY')]);

$queue = new Queue(["key" => getenv('QUEUE_KEY')]);

$taskData = [
    'summary' => 'exampleSummary',
    'description' => 'description',
    'assignee' => $assignee,
    'queue' => $queue
];

$task = new Task($taskData);
$result = $this->taskManager->createTaskObj($task);
</pre>
