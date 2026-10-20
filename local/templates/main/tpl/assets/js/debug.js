// глобальный namespace DJ
if (typeof(DJ) === 'undefined') {
	DJ = {};
}

// класс для отладочных сообщений
if (typeof(DJ.CDebug) === "undefined") {
	DJ.CDebug = class {

		log(msg, params = null) {
			console.log(msg, params);
		}

		error(msg, params = null) {
			console.log("%c CRITICAL ERROR: " + msg, "color:red; font-weight:bold", params);
		}
	}
}

// устанвовить режим отладки
DJ.setDebugMode = function() {
	document.cookie = "DJ_DEBUG=Y";
	DJ.Debug = new DJ.CDebug();
}

// создать переменная отладки
if (document.cookie.indexOf("DJ_DEBUG=Y;") !== -1) {
	DJ.Debug = new DJ.CDebug();
}