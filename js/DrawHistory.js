/**
 * Init helper with config.
 *
 * @requires Array.indexOf
 * @requires Logger
 * @requires jQuery UI
 *
 * @type DrawHistory
 */
var drawHistory = new DrawHistory({'':''
	, formSelector : '#content #search'
	, storageKey : 'DrawHistory'
	, formDataGetter: function() {
		var form = document.querySelector('#content #search');
		return {
			label: 'profil',
			values: [
				new DrawHistoryValue({label: 'Płeć'
					, value: form.plec.value
					, shortValue: DrawHistoryValue.firstLetter
				}),
				new DrawHistoryValue({label: 'Dzielnica'
					, value: form.miejsce.value
					, shortValue: DrawHistoryValue.firstLetter
				}),
				new DrawHistoryValue({label: 'Wiek'
					, value: DrawHistoryValue.range(form.wiek_od.value, form.wiek_do.value)
				}),
				new DrawHistoryValue({label: 'Wykształcenie'
					, value: form.wyksztalcenie.value
					, shortValue: DrawHistoryValue.firstLetter
				})
			]
		};
	}
	, labels: {'':''
		, 'time' : 'czas'
		, 'action-RandomApi' : 'losowanie 6 z listy'
		, 'action-GroupSet' : 'grupa'
	}
	, messages: {'':''
	}
});

function DrawHistory(config)
{
	var _self = this;

	this.config = config;
	this.LOG = new Logger('DrawHistory');

	// init store
	this.store = localforage.createInstance({
		name: config.storageKey
	});

	// data from last form submit
	this.lastFormData = null;
	$(function(){
		_self.lastFormData = config.formDataGetter();
	});

	// the history items
	this.history = null;
	$(function(){
		_self.load();
	});
}

DrawHistory.prototype.load = function(callback) {
	var _self = this;
	this.store.getItem('history').then(function(value){
		_self.history = (value === null) ? [] : value;
		if (callback) {
			callback();
		}
	});
};

DrawHistory.prototype.message = function(code) {
	var txt = (code in this.config.messages) ? this.config.messages[code] : code;
	alert(txt);
};

/**
 * Save Random.org event to history.
 * @param {Object} result Result object from Random.org API
 * (it's expected to contain at least `random` and `signature`)
 */
DrawHistory.prototype.saveRandomApi = function(result) {
	var historyItem = {
		formData : this.lastFormData,
		actionName : 'RandomApi',
		actionData : {
			random : result.random,
			signature : result.signature,
			result : result
		}
	};
	this.history.push(historyItem);
	this.store.setItem('history', this.history);
};

/**
 * Show history.
 */
DrawHistory.prototype.render = function(secondRun) {
	// just to be sure it's loaded
	var _self = this;
	if (this.history === null) {
		if (secondRun) {
			this.LOG.error('unable to render - loading history failed');
		}
		this.load(function(){
			_self.render(true);
		});
	}
	// render items
	for (var i = 0; i < this.history.length; i++) {
		var item = new DrawHistoryItem(this.history[i]);
		this.LOG.info(item.render());
	}
};