<?php

namespace AppBundle\Services\Search;

class Search
{
    public function searchInListById ($list, $id){
        foreach ($list as $item) {
			if ($item->getId() == $id){
				$itemFound = $item;
				break;
			}
		}
		return $itemFound;
    }
}