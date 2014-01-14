<?PHP
class rss {
	// READ ATOM 2.0 FEED
	static function read_atom2($url,$namespaces='') {
		// LOAD FEED
		$xml = simplexml_load_file($url, null, LIBXML_NOCDATA);
					
		// INITIALIZE RETURN VARIABLE
		$feed = array();
		$counter = 0;
		
		// MAKE SURE TO RETURN FULL FEED, JUST IN CASE
		$feed['full'] = $xml;
	
		// BUILD OUTPUT
		$feed['title'] = '<a href="'.$xml->channel->link.'" target="_blank">'.$xml->channel->title.'</a>';
	
		foreach($xml->channel->item as $item) {
			// LOAD COMMON FIELDS
			$feed['items'][$counter]['title'] = $item->title;
			$feed['items'][$counter]['description'] = $item->description;
			$feed['items'][$counter]['pubDate'] = $item->pubDate;
			$feed['items'][$counter]['link'] = $item->link;
			
			// IF NAMESPACES IS SET, LOAD NAMESPACE(S)
			if(!empty($namespaces)) {
				// GET NAMESPACES FROM FEED
				$ns = $item->getNameSpaces(true);
				
				if(is_array($namespaces)) {
					foreach($namespaces as $namespace) {
						$feed['items'][$counter][$namespace] = $item->children($ns[$namespace]);
					}
				}
				else {
					$feed['items'][$counter][$namespaces] = $item->children($ns[$namespaces]);
				}
			}
			
			$counter++;
		}
		
		return $feed;
	}
}
?>