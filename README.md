# PHP NTFY

A php library for publishing and subscribing messages to or from a [ntfy](https://ntfy.sh/) server.

### Client

```injectablephp
use PBergman\Ntfy\Api\Client;
use Symfony\Component\HttpClient\HttpClient;


$client = new Client(
    HttpClient::create([
        'base_uri' => 'https://ntfy.sh',
    ]),
);
```
For authentication the `auth_basic` or `auth_bearer` can be used or use a [AuthenticationInterface](src%2FAuthentication%2FAuthenticationInterface.php) as second argument:

```injectablephp
use PBergman\Ntfy\Api\Client;
use PBergman\Ntfy\Authentication\BasicAuthentication;
use Symfony\Component\HttpClient\HttpClient;

$client = new Client(
    HttpClient::create([
        'base_uri' => 'https://ntfy.sh',
    ]),
    new BasicAuthentication('username', 'password')
);
```

### Publishing

#### Simple message

```injectablephp
use PBergman\Ntfy\Model\PublishParameters;
use PBergman\Ntfy\Model\HttpAction;

$message = new PublishParameters('Hello world test!!!', 'Test title');
$message->setTags(['foo', 'bar']);
$message->addAction(new HttpAction('Google', 'https://google.nl'));
 
$response = $client->publish('test', $message); 
// will return a async response...
$response()->getId()
```

#### with Attachment

```injectablephp
use PBergman\Ntfy\Model\PublishParameters;
use PBergman\Ntfy\Model\HttpAction;

if (false !== $body = file_get_contents('out.txt')) {
    
    $message = new PublishParameters('Hello world test!!!', 'Test title');
    $message->setFilename('out.txt')
    $message->setTags(['foo', 'bar']);
    $message->addAction(new HttpAction('Google', 'https://google.nl'));
    
    $client->publish('test', $message, $body);
}
```

### Subscribing

```injectablephp
use PBergman\Ntfy\Model\SubscribeParameters;

$params = new SubscribeParameters();
$params->setSince('all');

foreach ($client->subscribe('test', $params) as $response) {
    printf("[%s] %s | %s\n", (new \DateTime('@' . $response->getTime()))->format(\DateTime::ATOM), $response->getTitle(), $response->getMessage());
}
```

Or to retrieve all message after a given id

```injectablephp
use PBergman\Ntfy\Model\SubscribeParameters;

$params = new SubscribeParameters();
$params->setSince('XXXXXXXXXX');
$params->setPoll(true);

$messages = \iterator_to_array($client->subscribe('test', $params)); 
```