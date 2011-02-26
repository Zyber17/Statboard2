<?php
$install = array(
	'name' => 'reddit',
	'author' => 'mattdr',
	'type' => 0,
	'has_install' => 0,
	'has_username' => 1,
	'has_password' => 0,
	'has_title' => 0
);

function reddit_function($username) {
  // I opted to use cURL here, since it can recover gracefully from errors,
  // whereas file_get_contents, at least in my environment, is liable to just
  // spit out the errors.
  
  // Then, in a big fat refactor, I pulled it into its own JSONRequest class.
  // That way, even if cURL is ugly to work with on a regular basis, we can
  // wrap it up in something that's just as pretty as the simple
  // file_get_contents call, and even does that parsing for us. Feel free to
  // modify as needed, pull into its own file, and require as needed.
  
  $request = new JSONRequest("http://www.reddit.com/user/$username/about.json");
  
  if($request->status() == 200) {
    $user = $request->response()->data;
    return array(
      'name' => "Reddit Karma",
      'title' => $username,
		  'data' => array(
        'for links' => $user->link_karma,
        'for comments' => $user->comment_karma
      )
    );
  } else {
    return array(
      'name' => "Reddit Karma",
      'title' => $username,
		  'kind' => 'error',
		  'type' => 0,
		  'data' => $request->status()
    );
  }
}

class JSONRequest {
  private $status;
  private $response;
  
  public function __construct($url) {
    // Given the URL, let's set up a cURL handle we can hold onto for later.
    // Really, it'd be nice if cURL were based on objects in the first place,
    // but we can wrap it up ourselves pretty easily.
    
    $this->ch = curl_init($url);
    curl_setopt($this->ch, CURLOPT_HEADER, 0);
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
  }
  
  public function response() {
    // This function can be called over and over, while only running the
    // request one time. exec() is called by response() or status() - whichever
    // gets called first - then the result is saved for the future.
    
    if(!isset($this->response)) $this->exec();
    return $this->response;
  }
  
  public function status() {
    if(!isset($this->status)) {
      $this->exec();
      $info = curl_getinfo($this->ch);
      $this->status = $info['http_code'];
    }
    return $this->status;
  }
  
  private function exec() {
    // While we're here, let's parse the JSON. If you have non-JSON needs, it
    // might be nice to make a more generic HTTPRequest class, then let
    // JSONRequest inherit from it, overriding HTTPRequest's empty parseContent
    // method with the json_decode call.
    
    $json = curl_exec($this->ch);
    $this->response = json_decode($json);
  }
  
  public function __destroy() {
    // If you end up needing to run in batch, this makes sure that, when you
    // run unset() on this request object, we don't introduce a memory leak.
    
    curl_close($this->ch);
  }
}
?>
