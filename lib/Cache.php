<?php
class Cache {
	const ALL_CONNECTIONS = "all_connections";
	const MY_DATA = "my_data";
	const CACHE_DIR = "cache";
	public function getCacheData($cacheType) {
		switch ($cacheType) {
			case Cache::ALL_CONNECTIONS :
			case Cache::MY_DATA :
				$serializedData = file_get_contents ( '..' . DIRECTORY_SEPARATOR . Cache::CACHE_DIR . DIRECTORY_SEPARATOR . $cacheType . '.txt' );
				return unserialize ( $serializedData );
				break;
			default :
				throw Exception ( "$cacheType is not allowed" );
		}
	}
	public function setCacheData($cacheType, $data) {
		switch ($cacheType) {
			case Cache::ALL_CONNECTIONS :
			case Cache::MY_DATA :
				$serializedData = serialize ( $data );
				file_put_contents ( '..' . DIRECTORY_SEPARATOR . Cache::CACHE_DIR . DIRECTORY_SEPARATOR . $cacheType . '.txt', $serializedData );
				break;
			default :
				throw Exception ( "$cacheType is not allowed" );
		}
	}
	public function deleteCache($cacheType) {
		switch ($cacheType) {
			case Cache::ALL_CONNECTIONS :
			case Cache::MY_DATA :
				@unlink ( '..' . DIRECTORY_SEPARATOR . Cache::CACHE_DIR . DIRECTORY_SEPARATOR . $cacheType . ".txt" );
				break;
			default :
				throw Exception ( "$cacheType is not present" );
		}
	}
}
