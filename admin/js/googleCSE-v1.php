<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');

/*
 * API for Google Custom Search Engine from Google
 * 
 * @compatibility	v1
 * @url				https://developers.google.com/custom-search/v1/overview
 * @url				https://developers.google.com/custom-search/v1/cse/list
 */

/*
 * On ne peut pas exécuter du code PHP dans un fichier JS,
 * à moins de modifier le php.ini
 * la parade est de définir les scripts javascripts dans un fichier php
 */
$component = JRequest::getVar('option');

$db = JFactory::getDbo();
$db->setQuery('SELECT params FROM #__extensions WHERE name = "'.$component.'"');
$params = json_decode( $db->loadResult(), true );


$key=$params['google_cse_key'];
$cx=$params['google_cse_cx'];

$search_url = "https://www.googleapis.com/customsearch/v1?key=".$key."&cx=".$cx."&alt=json&searchType=image&num=9&callback=jsonGetResponse";
?>

<script type="text/javascript">
	/* @brief	encode an img into a base64 string
	 * @url		http://stackoverflow.com/questions/246801/how-can-you-encode-a-string-to-base64-in-javascript
	 * 
	 * @param	(object)	image object
	 * @return	(string)	base64 data of object
	 */
	function getBase64Image(img) {  
		var canvas = document.createElement("canvas");  
		canvas.width = img.width;  
		canvas.height = img.height;  
		canvas.getContext("2d").drawImage(img, 0, 0);
		var dataURL = canvas.toDataURL("image/png");  
		// escape data:image prefix
		//return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");  
		// or just return dataURL
		return dataURL
	}
	//To get base64 of image by id:
	function getBase64ImageById(id){  
		return getBase64Image(document.getElementById(id));  
	}
</script>

<script type="text/javascript">
	function GAPI_image_search() {
		var query = "";
		var obj_marque = document.getElementById("jform_marque_id");
		if (document.getElementById("jform_cb_marque").checked) { query += obj_marque.options[obj_marque.selectedIndex].text; }
		if (document.getElementById("jform_cb_model").checked) { query += ((query != "") ? "+" : ""); query += document.getElementById("jform_label").value; }
		if (document.getElementById("jform_cb_url").checked) { query += ((query != "") ? "+" : ""); query += "site:"+parseURL(document.getElementById("jform_url").value).host; }
		
		var url = "<?php echo $search_url; ?>&q="+query.split(' ').join('+');
		console.log("query = %s", query);
		console.log("url = %s", url);
		var jsonRequest = new Request.JSONP({
			url: url,
			onSuccess: function(responseJSON, responseText){
				//console.log(responseText);
			},
			onError: function(text, error) {
				console.error(text);
				console.error(error);
			}
		}).send();
	}
	
	function jsonGetResponse(responseJSON) {
		console.log("%o", responseJSON);
		
		var div = document.getElementById("responseParagraph");
		div.innerHTML = "";
		Array.each(responseJSON.items, function(item, i) {
			//div.innerHTML += "<pre>" + item.image.thumbnailLink + "</pre>";
			div.innerHTML += "<a class='thumb' href='#' onclick='javascript:thumbClick(\""+item.link+"\");'><img id='thumb"+i+"' src='"+item.image.thumbnailLink+"' alt='thumb"+i+"' /></a>";
		});
	}
	
	function thumbClick_CORS_dontwork(thumbId) {
		//console.log("%o", link);
		//var thumb = document.getElementById(thumbId);
		var image = document.getElementById("jform_photo_img");
		//image.src = link;
		var input = document.getElementById("jform_photo");
		input.value = getBase64ImageById("jform_photo_img");
		image.src = input.value;
	}

	function thumbClick(src) {
		var url='components/com_velo/php/getExternalImage.php?src='+src;
		//var get_data = 'src='+src;
		var request = new Request({
			url: url,
			method:'get',
			/*get: get_data,*/
			onSuccess: function(responseText){
				//document.getElementById('system-debug').innerHTML=  responseText;
				$('jform_photo').empty();
				$('jform_photo').value = "data:image/png;base64,"+responseText;
				$('jform_photo_img').src = "data:image/png;base64,"+responseText;
			}
		}).send();
	}
</script>
