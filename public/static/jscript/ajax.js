/**
 * Creates an AJAX call using jQuery.load()
 * Data is inserted into DOM
 *
 * @param string sCall Name of the Component
 * @param string sExtra Extra params we plan to pass
 */
$.ajaxBox = function(sCall, sExtra)
{
	var sParams = getParam('sJsAjax') + '?' + getParam('sGlobalTokenName') + '[ajax]=true&' + getParam('sGlobalTokenName') + '[call]=' + sCall;
	if (sExtra)
	{
		sParams += '&' + sExtra;
	}	
	
	if (!sParams.match(/\[security_token\]/i))
	{
		sParams += '&' + getParam('sGlobalTokenName') + '[security_token]=' + getParam('sStaticVersion');
	}	
	
	return sParams;
};
var oCacheAjaxRequest = null;

window.onbeforeunload = function() 
{
	if (oCacheAjaxRequest !== null)
	{
		oCacheAjaxRequest.abort();
	}	
};

/**
 * Create AJAX Call
 *
 * @param	string	sFunction	Name of the function we plan to use
 * @param	string	sId	Form ID
 */
$.fn.ajaxCall = function(sCall, sExtra, bNoForm, sType, callback)
{	
	if (typeof(sCall) == 'undefined') {
		return;
	}

	if (empty(sType))
	{
		sType = 'POST';
	}
	
	var sUrl = getParam('sJsAjax'),
		sParams;
		
		
	if (sCall.substr(0, 7) == 'http://' || sCall.substr(0, 8) == 'https://') {
		sUrl = sCall;
		sParams = this.getForm();
	}
	else 
	{
		sParams = '&' + getParam('sGlobalTokenName') + '[ajax]=true&' + getParam('sGlobalTokenName') + '[call]=' + sCall + '' + (bNoForm ? '' : this.getForm());
		if (sExtra)
		{
			sParams += '&' + ltrim(sExtra, '&');
		}

		if (!sParams.match(/\[security_token\]/i))
		{
			sParams += '&' + getParam('sGlobalTokenName') + '[security_token]=' + getParam('sStaticVersion');
		}		
		sParams += '&' + getParam('sGlobalTokenName') + '[hl]=' + getParam('hl');
	}	
	var params = {
		type: sType,
		url: sUrl,
		dataType: "script",
		data: sParams
	};
	
	var self = this;
	if (typeof(callback) == 'function') {
		params.success = function(e) {
			callback(e, self);
		};
	}
	oCacheAjaxRequest = $.ajax(params);
	return oCacheAjaxRequest;
};

$.ajaxCall = function(sCall, sExtra, sType)
{
	if ($('body').hasClass('page-loading')) return false;
    return $.fn.ajaxCall(sCall, sExtra, true, sType);
};
/**
 * Get form details
 * @param	string	frm	Form ID or Element ID
 * @return	string	Return parsed URL string
 */
$.fn.getForm = function()
{
	var objForm = this.get(0);	
	var prefix = "";
	var submitDisabledElements = false;
	
	if (arguments.length > 1 && arguments[1] == true)
	{
		submitDisabledElements = true;
	}
	
	if(arguments.length > 2)
	{
		prefix = arguments[2];
	}

	var sXml = '';
	if (objForm && objForm.tagName == 'FORM')
	{
		var formElements = objForm.elements;		
		for(var i=0; i < formElements.length; i++)
		{
			if (!formElements[i].name)
			{
				continue;
			}
			
			if (formElements[i].name.substring(0, prefix.length) != prefix)
			{
				continue;
			}
			
			if (formElements[i].type && (formElements[i].type == 'radio' || formElements[i].type == 'checkbox') && formElements[i].checked == false)
			{
				continue;
			}
			
			if (formElements[i].disabled && formElements[i].disabled == true && submitDisabledElements == false)
			{
				continue;
			}
			
			var name = formElements[i].name;
			if (name)
			{				
				sXml += '&';
				if(formElements[i].type=='select-multiple')
				{
					for (var j = 0; j < formElements[i].length; j++)
					{
						if (formElements[i].options[j].selected == true)
						{
							sXml += name+"="+encodeURIComponent(formElements[i].options[j].value)+"&";
						}
					}
				}
				else
				{
					sXml += name+"="+encodeURIComponent(formElements[i].value);
				}
			}
		}
	}	

	if ( !sXml && objForm)
	{
		sXml += "&" + objForm.name + "="+ encodeURIComponent(objForm.value);
	}	
	
	return sXml;
};



