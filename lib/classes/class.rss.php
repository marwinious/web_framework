<?PHP
class rss {
	// READ ATOM 2.0 FEED
	static function read_atom2($url) {
		$xml = simplexml_load_file($url, null, LIBXML_NOCDATA);
					
		$feed = array();
		
		$feed['title'] = '<a href="'.$xml->channel->link.'" target="_blank">'.$xml->channel->title.'</a>';
		
		$counter = 0;
		
		foreach($xml->channel->item as $item) {
			$feed['items'][$counter]['title'] = $item->title;
			$feed['items'][$counter]['description'] = $item->description;
			$feed['items'][$counter]['pubDate'] = $item->pubDate;
			$feed['items'][$counter]['link'] = $item->link;
			$counter++;
		}
		
		return $feed;
	}
}
?>