<?php
interface Application_Service_ICrawler {
	/**
	 * get other sub links
	 */
	public function getLinks($html);
	/**
	 * load html page of a link and get needed Infos
	 */
	public function extractHTML($link);
	
	/**
	 * prepare sql commands in order to execute after
	 */
	public function prepareSQl();
}