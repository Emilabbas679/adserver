var $bDocumentIsLoaded = false;
var $Cache = {};
var $oStaticHistory = {};

if (typeof window.console == 'undefined')
{
	window.console = { log : function(sTxt){} };
}
if (typeof window.console.log == 'undefined')
{
	window.console.log = function(sTxt){};
}
$.fn.message = function(sMessage, sType)
{
	switch(sType)
	{
		case 'valid':
			sClass = 'valid_message';
			break;
		case 'error':
			sClass = 'error_message';
			break;
		case 'public':
			sClass = 'public_message';
			break;
	}

	this.html(this.html() + '<div class="' + sClass + '">' + sMessage + '</\div>');

	return this;
};
$.getParams = function(sUrl)
{
	var aArgs = sUrl.split('#');
	var aArgsFinal = aArgs[1].split('?');
	var aFinal = aArgsFinal[1].split('&');

	var aUrlParams = Array();

	for (count = 0; count < aFinal.length; count++)
	{
		var aArg = aFinal[count].split('=');

		aUrlParams[aArg[0]] = aArg[1];
	}

	return aUrlParams;
};
$.ajaxProcess = function(sMessage)
{
	sMessage = (sMessage ? sMessage : getPhrase('core.processing'));
	return '<span style="margin-left:4px; margin-right:4px; font-size:9pt; font-weight:normal;">' + (sMessage === 'no_message' ? '' : sMessage + '...') + '</span>';
};
$Behavior.imageHoverHolder = function()
{
	// Confirm before deleting an item
	$('.sJsConfirm').click(function()
	{
		if (confirm(getPhrase('core.are_you_sure')))
		{
			return true;
		}
		return false;
	});


	
}	
$Core.exists = function(sSelector)
{
	return ($(sSelector).length > 0 ? true : false);
};


$Core.hasPushState = function(){
	return (typeof(window.history.pushState) == 'function' ? true : false);
};

$Core.box = function($sRequest, $sWidth, $sParams)
{
	tb_show('', $.ajaxBox($sRequest, 'width=' + $sWidth + ($sParams ? '&' + $sParams : '')));	
	
	return false;
};



/**
 * Adds a hash to the URL string, which is used to emulate a AJAX page
 *
 * @param object oObject Is the anchor object (this)
 */
$Core.addUrlPager = function(oObject, bShort)
{
	if ($Core.hasPushState()){
		window.history.pushState('', '', oObject.href);
	}
	else{
		window.location = '#!' + (bShort ? oObject.href : $Core.getRequests(oObject.href, true));
	}
};


$Core.processing = function()
{
	$('.ajax_processing').remove();
	$('body').prepend('<div class="ajax_processing"><i class="fa fa-spin fa-circle-o-notch"></i></div>');
};

$Core.processingEnd = function() {
	$('.ajax_processing').fadeOut();
};
$Core.ajaxMessage = function()
{
	$('#global_ajax_message').html('<i class="fa fa-spin fa-circle-o-notch"></i>').show();
};

$Core.reloadPage = function()
{
	/* which is why we have these fallbacks*/
	if (typeof window.location.reload == 'function') window.location.reload();
	else if (typeof history != 'undefined' && history.go == 'function') history.go(0);	
};

$Core.loadStaticFile = function($aFiles)
{
	$Core.loadStaticFiles($aFiles);
};
$Core.loadStaticFiles = function($aFiles)
{
	if (typeof($aFiles) == 'string')
	{
		$aFiles = new Array($aFiles);
	}
	if (typeof($Core.core_bundle_files) == 'undefined')
	{
		$Core.core_bundle_files = [];
	}
	
	$($aFiles).each(function($sKey, $sFile)
	{
		if (!isset($oStaticHistory[$sFile]) && ($Core.core_bundle_files.indexOf($sFile) == -1))
		{
			$oStaticHistory[$sFile] = true;
			
			if (substr($sFile, -3) == '.js')
			{
				$.ajax($sFile + '?v=' + getParam('sStaticVersion') + '').always(function(){
					//$Core.dynamic_js_files--;
				});
			}
			else if (substr($sFile, -4) == '.css')
			{
				$('head').prepend('<link rel="stylesheet" type="text/css" href="' + $sFile + '?v=' + getParam('sStaticVersion') + '" />');
			}
			else
			{
				eval($sFile);
			}
		}
	});	
}
$Core.loadInit = function()
{
	$.each($Behavior, function()
	{
		this(this);
	});
};



