/*
** CLASS CheckForm
**
** Site 	:	http://checkforml.imagika.fr
**
** Créée par Mickael B. Alexandre
**
** Site 	:	http://imagika.fr
** Blog	:	http://mickaelbertrand.imagika.fr
**
**
** Version 0.6 datée du 13-07-2009
** Modifications du 01-08-2009 : Debug
**
** Licence ATC MIW - Promotion 2008-2009
** http://www.gap.univ-mrs.fr/miw/
**
** Classe sous LICENCE X-11
**
** ######################################################
**	Paramétrage de la classe : ---------------------------------------------------------------------------------------------------------------
**		- msgElement 	Type		@String
**					Desc		balise qui sera créée et dans laquelle le message d'erreur sera affichée
**					Valeurs		li, div, span, p, strong, etc...
**
**		- debug		Type		@Boolean
**					Desc		Si activé les message d'erreur de la classe apparaitront en alert
**					Valeurs 	true (debug activé), false (desactivé)
**
**		- authorizeKeyControl	Type		@Boolean
**					Desc		mode qui empeche de taper les touches qui ne correpondraient pas à la regex
**					Valeurs 	true (activé), false (désactivé)
**
**		- validateColor		Type		@String
**					Desc		Code couleur si champs valide
**					Valeurs 	#FFF, ... ,#000000, transparent
**
**		- errorColor		Type		@String
**					Desc		Code couleur si champs invalide
**					Valeurs 	#FFF, ... ,#000000, transparent
**
**		- msgAttributes		Type		@Array
**					Desc		Contient tous les attributs pour la personnalisation du message d'erreur
**					Valeurs 	'attribut' : 'valeur'
**
**		- idMsg			Type		@Array
**					Desc		Contient l'id du conteneur dans lequel vous voulez afficher les messages
**							Sinon si null affichage du message directement après le champs concerné
**					Valeurs 	un id d'un element Html ou null
**
**		- defaultLinkOperator	Type		@String
**					Desc		L'opérateur qui permettra la comparaison de deux champs
**					Valeurs 	==, <, >, <=, >=, !=
**
**		- regSeparator		Type		@String
**					Desc		L'opérateur qui permettra la comparaison de deux champs
**					Valeurs 	tous les caractères sauf les alphanumérique et numérique (ex : - ou - ou , etc...)
**
**	Class : -------------------------------------------------------------------------------------------------------------------------
**		- formulaire	@Element 		élément qui pointe sur le formulaire par défaut document
**		- c			@Array		contient les identifiants des champs à controler( id ou name)
**		- value		@Array		contient la valeur du champs à controler
**		- t			@Array		contient les types des champs à controler (text, textArea, select,
**                                                        			textBox, textRadio, button etc ..)
**		- r			@Array		contient les règles de validation des champs à contrôler ( required,
**									requiredLenFix,alpha,alphaLenFix, alphanum,alphanumLenfix,
**									number, email, phone, url, digit, nodigit, verif , expReg etc )
**		- m			@Array		contient les messages à afficher si les champs à contrôler ne
**									respectent pas les règles définies
**		- p			@Array		contient éventuellement des paramètres exemple:min[min,max]
**		- l			@Array		contient éventuellement des champs liés entre eux
**		- messageError	@Array		contenant tous les erreurs trouvées dans le formulaire indice n étant le numéro de chaque règle
**		- reg			@Array		contient toutes les regex possibles
**		- authorized	@Array		contient tous les caractères possibles
**
** @fonctions :  ############################################################
**	MODIFIEURS : ---------------------------------------------------------------------------------------------------------------
**		- setValue
**		- setFormulaire
**		- setAuthorizeKeyControl
**		- setDebug
**		- setValidateColor
**		- setErrorColor
**		- setMsgElement
**
**	ACCESSEURS : ---------------------------------------------------------------------------------------------------------------
**		- getMessageError
**
**	EVENT FUNCTIONS : ---------------------------------------------------------------------------------------------------------------
**		- traiteKeyCode
**		- traitePress
**		- traiteSubmit
**
**	OTHERS FUNCTIONS : ---------------------------------------------------------------------------------------------------------------
**		- addReg
**		- initialise
**		- validateReg
**		- execute
**
**	MESSAGE FUNCTIONS : ---------------------------------------------------------------------------------------------------------------
**		- hiddeMsg
**		- afficheMsg
**		- colorize
**		- showError
**
**	SYSTEM FUNCTIONS : ---------------------------------------------------------------------------------------------------------------
**		- $
**		- insertAfter
**		- addEventListener
**		- removeEventListener
**		- bind
**
**
*/

//@fid 	string (id du formulaire cible)
function CheckForm(fid) {
	this.fid = fid;
	this.setFormulaire(fid);

	this.formulaire 	= document;
	this.messageError 	= [];
	this.value			= [];
	this.c				= [];
	this.t				= [];
	this.r				= [];
	this.m				= [];
	this.p				= [];
	this.l				= [];
	this.ol				= [];
	this.e				= [];
	this.tab_comp		= [];
	this.type_comp		= [];
	this.custom_cond 	= [];

}//__construct

CheckForm.prototype = {


	/* ***Paramétrage de la classe*** */


	debug				: false,
	authorizeKeyControl	: false,

	formLock			: true,
	/*
	FEATURED
	closeButton			: true,
	*/

	idMsg				: null,

	defaultLinkOperator	: '==',

	regSeparator		: ':',

	msgElement			: 'li',
	validateColor		: '#F4FFC7',
	errorColor			: '#FFCACA',

	//on peut ajouter autant d'attribut de balise qu'on le souhaite (title,src,title,...)
	msgAttributes	: {
		 'style' : 'list-style-type:none;background-image:url("style/img/cross.png");background-repeat:no-repeat;background-position:1% 50%;padding-left:25px;padding-right:7px;padding-top:1px;padding-bottom:1px;background-color:#FFDDE4;-moz-border-radius:10px;',
		 'class': 'checkform-error'
	},

	// Image au lieu d'un message
	isImgDisplay 			: false,
	validateImg 			: './Img/checkform-validate.png',
	//facultatif
	errorImg 				: './Img/checkform-error.png',

	//utiliser pour les comparaison sur tableaux
	casseSensitive			: true,

	/* *** Fin de paramétrage de la classe*** */


	//données membres

	formulaire 	: document,
	messageError: [],
	value		: [],
	c			: [],
	t			: [],
	r			: [],
	m			: [],
	p			: [],
	l			: [],
	ol			: [],
	e			: [],
	tab_comp	: [],
	//type de comparaison sur le tableau :
		//N (de 0 à N) -> ce chiffre sera le nombre d'élément dans le tableau qui doivent être compris dans un texte (ou de chiffres dans un nombre)   0 équivalent a une exclusion
		//texte_rand ->   Les éléments du tableau doivent tous être dans le texte quelque soit l'ordre
	type_comp	: [],
	custom_cond : [],

	authorized: {
		alpha 		: /^[a-zÀÂÇÈÉÊËÎÔÙÛàâçèéêëîôùû ._\-]$/i,
		alphanum 	: /^[a-z0-9 ._\-]$/i,
		digitSign 	: /^[\-+0-9]$/,
		digit 		: /^[0-9]$/,
		nodigit 	: /^[^0-9]$/,
		number 		: /^[\d\.]$/,
		email 		: /^[a-zA-Z0-9\._%@\-]$/i,
		phone 		: /^[\d\s\+\.\-]$/,
		url 		: /^[a-z0-9\-\.\/_]$/i,
		date 		: /^[0-9\s\. ]$/,
		hexaColor 	: /#[0-9a-fA-F]$/
	},


	reg:{
		required 	: /[^.*]/,
		alpha 		: /^[a-zÀÂÇÈÉÊËÎÔÙÛàâçèéêëîôùû ._\-]+$/i,
		alphanum 	: /^[a-z0-9 ._\-]+$/i,
		digitSign 	: /^[\-+]?[0-9]+$/,
		digit		: /^[0-9]+$/i,
		nodigit 	: /^[^0-9]+$/,
		number 		: /^[\-+]?\d*\.?\d+$/,
		email 		: /^[a-z0-9._%\-]+@[a-z0-9.\-]+\.[a-z]{2,4}$/i,
		phone 		: /^[0-9]{2}[\s]{0,1}[0-9]{2}[\s]{0,1}[0-9]{2}[\s]{0,1}[0-9]{2}[\s]{0,1}[0-9]{2}$/,
		url 		: /^(http|https):\/\/[a-z0-9\-\.\/_]+\.[a-z]{2,3}$/i,
		date 		: /^[0-9]{1,2}.[0-9]{1,2}.[0-9]{2,4}$/,
		hexaColor 	: /#[0-9a-fA-F]{6}/,
		notEmpty 	: /^(.*[^0\s].*)$/
		//le cas custom est créé dans addReg ou non en fonction des désir de l'utilisateur
	},

	prevKeyCode : '',

	keyCodeValues : {
		32 : ' ',  9  : '\t', 13 : '\n', 48 : 'à', 49 : '&', 50 : 'é',
		51 : '"',  52 : "'",  53 : '(',  54 : '-',  5 : 'è', 56 : '_',
		57 : 'ç',

		96 : '0',  97 : '1',   98 : '2', 99 : '3', 100 : '4', 101 : '5',
		102 : '6',103 : '7', 104 : '8',	105 : '9',

		65 : 'a', 66 : 'b',  67 : 'c',
		68 : 'd', 69 : 'e',  70 : 'f',
		71 : 'g', 72 : 'h',  73 : 'i',
		74 : 'j', 75 : 'k',  76 : 'l',
		77 : 'm', 78 : 'n',  79 : 'o',
		80 : 'p', 81 : 'q',  82 : 'r',
		83 : 's', 84 : 't',  85 : 'u',
		86 : 'v', 87 : 'w',  88 : 'x',
		89 : 'y', 90 : 'z',	 91 : '.',

		111 : '/',109 : '-',  107 : '+', 106 : '*',
		186 : ';',187 : '=',  188 : ',', 189 : '-', 191 : '/',
		220 : '\\', 219 : ')',222 : '\'',221 : '^', 192 : '`', 190 : ';'

	},

	fieldModif : {
		'field_id' : 'c',
		'field_type' : 't',
		'field_reg' : 'r',
		'field_msg' : 'm',
		'field_event' : 'e',
		'field_tab_comp' : 'tab_comp',
		'field_type_comp' : 'type_comp',
		'field_custom_cond' : 'custom_cond'
	},


	/* ***** SET FUNCTIONS ****** */


	//@elem	element 	(élément dont il faut récupérer la valeur)
	//@n		number	(numéro de la règle sur lequel doit porter cet ajout)
	//desc 	initialise dans le tableau value la valeur du champs
	setValue : function (elem, n) {
		//prend la valeur du champs
		if (elem.value !== '') {
			this.value[n] = elem.value;
		}
		else {
			this.value[n] = '';
		}
	},

	//@fid	string (id of the form)
	//desc	initialise l'élément formulaire ave le fid
	setFormulaire: function (fid) {
		this.formulaire = document.getElementById(fid);
		if(this.formulaire.nodeName == 'FORM') {
			this.addEventListener(this.formulaire,"submit",this.bind(this,this.traiteSubmit),false);
		}
		else if(this.formulaire.nodeName == 'INPUT') {
			this.addEventListener(this.formulaire,"click",this.bind(this,this.traiteSubmit),false);
		}
	},

	//@bool	boolean (true = debug activated)
	//desc	initialise the debug mode
	setDebug: function (bool) {
		this.debug = bool;
	},

	//@bool	boolean (true = press control activated)
	//desc	initialise the control mode
	setAuthorizeKeyControl: function (bool) {
		this.authorizeKeyControl = bool;
	},

	//@value	boolean
	//desc 	initialise la donnée membre formLock
	setFormLock: function (value) {
		this.formLock = value;
	},

	//@value	boolean
	//desc 	initialise la donnée membre isImgDisplay
	setIsImgDisplay: function (value) {
		this.isImgDisplay = value;
	},

	//@value	string (id du conteneur)
	//desc 	initialise la donnée membre idMsg
	setIdMsg: function (value) {
		this.idMsg = value;
	},

	//@value	string (operator :  ==, !=, >, <, <=, >=, ===, !==)
	//desc 	initialise la donnée membre defaultLinkOperator
	setDefaultLinkOperator: function (value) {
		this.defaultLinkOperator = value;
	},

	//@value	string (separator, n'importe quel caractère ou ensemble de caractères)
	//desc 	initialise la donnée membre regSeparator
	setRegSeparator: function (value) {
		this.regSeparator = value;
	},

	//@value	string (valeur du message)
	//desc 	initialise la donnée membre msgElement
	setMsgElement: function (value) {
		this.msgElement = value;
	},

	//@color	string (hexadecimal color (ex : #fff or #03A93A)
	//desc	initialise the validateColor
	setValidateColor: function (color) {
		this.validateColor = color;
	},

	//@color	string (hexadecimal color (ex : #fff or #03A93A)
	//desc	initialise the errorColor
	setErrorColor: function (color) {
		this.errorColor = color;
	},

	//@color	array
	//desc	initialise the msgAttributes
	setMsgAttributes: function (array) {
		this.msgAttributes = array;
	},

	//@color	boolean
	//desc	initialise the msgAttributes
	setCasseSensitive: function (value) {
		this.casseSensitive = value;
	},

	//@chp		identifiant du champ dont la règle doit etre supprimée (id, name ou numéro de règle)
	//@element	élement visé par la modification (ex : field_id,field_type, etc.. pour plus de précisions voir le tableau fieldModif)
	//@value		valeur que l'on veut donner à l'élement
	//desc 		initialise la donnée membre formLock
	setElement: function (chp, element, value) {
		var num_reg = this.getNumReg(chp);

		if(num_reg !== false) {
			this[this.fieldModif[element]][num_reg] = value;
		}
	},


	/* ***** GET FUNCTIONS ****** */

	//desc 	retourne le message d'erreur courant
	getMessageError: function() {
		return this.messageError;
	},


	/* ***** EVENT FUNCTIONS ****** */

	traiteKeyCode : function (keyCode,loc_e) {
		var return_value = null;
		if(typeof(this.keyCodeValues[keyCode]) !== 'undefined' && ! loc_e.shiftKey && ! loc_e.altKey) {
			return_value = this.keyCodeValues[keyCode];
		}
		else if(typeof(this.keyCodeValues[keyCode]) !== 'undefined' && (this.prevKeyCode == 16 || loc_e.shiftKey)) {
			switch(keyCode) {
				case 48 :
					return_value = '0';
					break;
				case 219 :
					return_value = '°';
					break;
				case 107 :
					return_value = '+';
					break;
				case 190 :
					return_value = '.';
					break;
				default :
					return_value = (keyCode % 48);
			}
		}
		else if(typeof(this.keyCodeValues[keyCode]) !== 'undefined' && (this.prevKeyCode == 18 || loc_e.altKey)) {
			switch(keyCode) {
				case 48 :
					return_value = '@';
					break;
				case 49 :
					return_value = '^';
					break;
				case 50 :
					return_value = '~';
					break;
				case 55 :
					return_value = '`';
					break;
				case 52 :
					return_value = '|';
					break;
				case 53 :
					return_value = '[';
					break;
				case 54 :
					return_value = '{';
					break;
				case 51 :
					return_value = '#';
					break;
				case 56 :
					return_value = '\\';
					break;
				case 219 :
					return_value = ']';
					break;
				case 107 :
					return_value = '}';
					break;
				default :
					return_value =  this.keyCodeValues[keyCode];
			}
		}
		else if (typeof(this.keyCodeValues[keyCode]) !== 'undefined') {
			return_value =  this.keyCodeValues[keyCode];
		}

		this.prevKeyCode = keyCode;
		return return_value;
	},

	traitePress : function (n,e) {
		var loc_e = e || window.event;
		//on autorise les flèches directionelles, le tab et le retour en arrière
		if(loc_e.keyCode == 9 || loc_e.keyCode == 8 || loc_e.keyCode == 37 || loc_e.keyCode == 38
			|| loc_e.keyCode == 39 || loc_e.keyCode == 40) {
			return;
		}
		var loc_reg = this.parseReg(this.r[n]);
		for(i in loc_reg) {
			if ( typeof(this.authorized[loc_reg[i]]) !== 'undefined')
			{
				var keyValue = this.traiteKeyCode(loc_e.keyCode, loc_e);
				if (this.authorized[loc_reg[i]].test(keyValue) === false && (loc_reg[i] != 'required' || keyValue != '')) {
					this.messageError[n] = this.m[n];
					break;
				}
				else {
					delete this.messageError[n];
				}
			}
		}

		if (typeof(this.messageError[n]) !== 'undefined') { // && (this.messageError.join('')).length !== 0) {
			if (loc_e.preventDefault) {
			   loc_e.preventDefault();  // FF
			}
			loc_e.returnValue = false;  // IE
			return false;
		}

		this.validateReg(n);
	},

	traiteSubmit: function (e) {
		this.validateReg();
		if (this.messageError !== '' && (this.messageError.join('')).length !== 0 && this.formLock === true) {
			var loc_e = e || window.event;
			if (loc_e.preventDefault) {
			   loc_e.preventDefault();  // FF
			}
			loc_e.returnValue = false;  // IE

			return false;
		}
	},

	/* ***** EXECUTION FUNCTIONS ****** */


	//@chp			identifiant du champ dont la règle doit etre supprimée (id, name ou numéro de règle)
	//desc			Supprime une règle
	delReg: function (chp) {
		var num_reg = this.getNumReg(chp);

		//on supprimer l'ecouteur d'evenement sur le champs dont on désire supprimer les règle
		//a voir si c'est réellement utile...
		this.removeEventListener(this.$(chp),this.e[num_reg],this.bind(this,this.validateReg,[num_reg]),false);

		this.value[num_reg] = "";
		this.c[num_reg] = "";
		this.t[num_reg] = "";
		this.r[num_reg] = "";
		this.m[num_reg] = "";
		this.p[num_reg] = "";
		this.l[num_reg] = "";
		this.ol[num_reg] = "";
		this.e[num_reg] = "";
		this.tab_comp[num_reg] = "";
		this.type_comp[num_reg] = "";
		this.custom_cond[num_reg] = "";

		delete this.messageError[num_reg];
		//si le mode image est initialisé
		if(this.isImgDisplay === true) {
			this.afficheMsg(num_reg);
		} else {
			this.hiddeMsg(num_reg);
		}

	},

	//@chp			identifiant du champ à contrôler (id ou name)
	//@typ			type du champ à contrôler
	//@reg			règle à appliquer sur le champ
	//@event			event qui déclenche la validation
	//@mes			message à afficher si la règle n'est pas vérifiée
	//@par			paramètre facultatif pouvant préciser la règle supplémentaire. (taille de la value)
	//@custom_reg		paramètre facultatif pouvant préciser la règex à utiliser.
	//@liens			paramètre facultatif pouvant préciser les champs liés
	//@operateur_liens	L'opérateur utilisé pour comparé deux champs liés
	//@tab_comp		tableau de valeurs
	//@type_comp		type de comparaisons entre la valeur entrée et les valeurs du tab_comp
	//@custom_cond	Est une condition qui vous permttra de tester la valeur rentrée par l'utilisateur
	//					(ex : '>100', retournera une erreur si la value est infèrieure à 100)
	//desc			initialise les tableaux de description d'un champ
	//				permet d'enregistrer une nouvelle règle
	addReg: function (chp, typ, reg, event, mes, par, custom_reg, liens, operateur_liens, tab_comp, type_comp,custom_cond) {

		var num_reg = this.getNumReg(chp);
		if(num_reg !== false) { return false; }

		if ( this.$(chp) !== null )
		{
			//on passe à initialise le tableau d'argument de la fonction
			this.initialise(arguments);
			var att = this.c.length-1;

			//on ajoute l'écouteur sur tous les radio ou checkbox portant ce name
			if (typeof(typ) != 'undefined')
			{
				if (typ == 'radio' || typ == 'checkbox'){
					var tab_element = document.getElementsByName(chp);
					for (var i=0, sz = tab_element.length; i < sz; i++) {
						this.addEventListener(tab_element[i],event,this.bind(this,this.validateReg,[att]),false);
					}
				}
				else
					this.addEventListener(this.$(chp),event,this.bind(this,this.validateReg,[att]),false);
			}

			if ( this.authorizeKeyControl === true && this.existAuthorizedReg(att))
			{
				this.addEventListener(this.$(chp),'keydown',this.bind(this,this.traitePress,[att]),false);
			}


		}
		else { this.showError('Développeur : Attention l\'élément id = "' + chp + '" n\'existe pas.\n'
							+'l\'élément name = "' + chp + '" n\'existe pas non plus.');
		}

	},

	//desc 	cette fonction récupère un tableau de paramètre donné par addReg
	initialise: function() {
		this.c.push(arguments['0']['0']);
		this.t.push(arguments['0']['1']);
		this.r.push(arguments['0']['2']);
		this.e.push(arguments['0']['3']);
		this.m.push(arguments['0']['4']);
		this.p.push(arguments['0']['5']);
		//on ajoute à reg une regex custom
		var custom = arguments['0']['6'];
		if ( custom !== '' && custom != 'undefined' && typeof(custom) != 'undefined'){
			this.reg.custom = custom;
		}
		//on ajoute à un l les liens
		this.l.push((arguments['0']['7'] != 'undefined') ? arguments['0']['7'] : '') ;
		//on ajoute l'opérateur pour le lien courant
		this.ol.push((arguments['0']['8'] != 'undefined') ? arguments['0']['8'] : '') ;
		//on ajoute les valeurs auxquelles la valeur du champs controlé
		this.tab_comp.push((arguments['0']['9'] != 'undefined') ? arguments['0']['9'] : '') ;
		//type de comparaison pour le tab_comp
		this.type_comp.push((arguments['0']['10'] != 'undefined') ? arguments['0']['10'] : '') ;
		//condition sur la value
		this.custom_cond.push((arguments['0']['11'] != 'undefined') ? arguments['0']['11'] : '') ;
	},

	//@param		le numéro des règles à valider
	//desc		Valide une ou plusieurs règles
	validateReg: function() {
		if (arguments.length !== 0)
		{
			for (var i = 0 , sz = arguments.length; i < sz ; ++i) {
				this.execute(arguments[i]);
			}
		}
		else
		{
			for (var n in this.t) {
				if(n != 'undefined') {
					this.execute(n);
				}
			}
		}
	},
	//@n 	number
	//desc 	execute les opération sur un champs
	execute: function (n) {
		if(isNaN(n) || this.c[n] == '') { return; }

		this.setValue(this.$(this.c[n]),n);

		var loc_reg = this.parseReg(this.r[n]);

		var isError = false;

		if (loc_reg.length !== 0)
		{
			for(i in loc_reg) {
				if(typeof(loc_reg[i]) == 'string') {
					if ( ! this.reg[loc_reg[i]].test(this.value[n]) && ( this.isRequired(n) || this.value[n] != '')) {
						isError = true; break;
					}
				}
			}
		}
		if (typeof(this.p[n]) != 'undefined')
		{
			var length = (typeof(this.value[n]) == 'undefined') ? 0 : this.value[n].length;
			if ( length < this.p[n]['0'] || length > this.p[n]['1'] ) {
				isError = true;
			}
		}
		if (typeof(this.t[n]) != 'undefined')
		{
			var tab_element = document.getElementsByName(this.c[n]);
			var nb_checked = 0;

			for (var i=0, sz = tab_element.length; i < sz ; i++) {
				//debug ?
				if(typeof(tab_element[i]) !== 'object'){ continue; }
				if(tab_element[i].checked === true) {
					++nb_checked;
				}
			}

			if (this.t[n] == 'radio'){
				if ( this.r[n] == 'required') {
					if (nb_checked < 1) {
						isError = true;
					}
				}
				//this hack may be possible but... useless ?
				if ( nb_checked > 1) {
					isError = true;
				}
			}
			else if (this.t[n] == 'checkbox')
			{
				if (typeof(this.p[n]) != 'undefined')
				{
					if ( nb_checked < this.p[n]['0'] || nb_checked > this.p[n]['1'] )
						isError = true;
				}
			}
		}

		if (typeof(this.l[n]) != 'undefined')
		{
			for ( var i in this.l[n] )
			{
				var operator = (typeof(this.ol[n]) !== 'undefined') ? this.ol[n] : this.defaultLinkOperator;

				if ( ! eval("'"+this.value[n]+"' "+operator+" '"+this.$(this.l[n][i]).value+"'")) {
					isError = true;
				}
			}
		}

		if (typeof(this.tab_comp[n]) != 'undefined')
		{
			var tab_words = this.value[n].split(' ');
			var nb_found = 0;

			//pour chaque occurence du tableau de comparaison on regarde chaque mot du texte
			for ( var i = 0, sz=this.tab_comp[n].length; i < sz ; ++i)
			{
				for( var j = 0, sz2=tab_words.length; j < sz2 ; ++j)
				{
					if(this.casseSensitive === false) {
						if ( this.tab_comp[n][i].toLowerCase() == tab_words[j].toLowerCase() ) { ++nb_found; }
					} else {
						if ( this.tab_comp[n][i] == tab_words[j] ) { ++nb_found; }
					}
				}
			}
			var nb_nf = this.tab_comp[n].length - nb_found;

			if (this.type_comp[n] == 'texte_rand') {
				if(nb_found != this.tab_comp[n].length) { isError = true; }
			} else {
				//si on est dans le cas du type = N et que le nombre de correspondances trouvée n'est pas égal à ce nombre
				if (this.type_comp[n] >= 0) {
					if(nb_found != this.type_comp[n]) { isError = true; }
				} else if(nb_found == 0) {
					//la value n'a pas été trouvée dans le tableau et le type ne vaut pas exclusion
					isError = true;
				}
			}
		}

		if (typeof(this.custom_cond[n]) != 'undefined')
		{
			if ( ! eval("'"+this.value[n]+"' "+this.custom_cond[n])) {
				isError = true;
			}
		}

		if (isError)
		{
			this.messageError[n] = this.m[n];
			this.afficheMsg(n);
		}
		else {
			delete this.messageError[n];
			//si le mode image est initialisé
			if(this.isImgDisplay === true) {
				this.afficheMsg(n);
			} else {
				this.hiddeMsg(n);
			}
		}
	},


	/* ***** DISPLAY FUNCTIONS ****** */


	//desc 	supprime le node relatif au message
	hiddeMsg: function (n) {
		//destruction du message
		if (document.getElementById(this.fid+'-msg-error-'+n) === null) { return false; }

		var node = document.getElementById(this.fid+'-msg-error-'+n);
		node.parentNode.removeChild(node);

		//colorisation du champ
		this.colorize(n,false);
	},

	//desc 	créée le node relatif au message
	afficheMsg: function (n) {
		//construction du message
		this.hiddeMsg(n);

		var new_node = document.createElement(this.msgElement);
		new_node.id = this.fid+'-msg-error-'+n;

		var txt = this.messageError[n];

		//si le mode image est initialisé
		if(this.isImgDisplay === true) {
			new_node.className = 'checkform-img-error';
			var image = document.createElement('img');
			image.id = this.fid+'-checkform-image-'+n;

			//si le message est vide alors le champs est valide
			if(typeof(txt) == 'undefined') { image.src = this.validateImg; }
			else if (this.errorImg != '') { image.src = this.errorImg; }

			new_node.appendChild(image);

		} else {
			new_node.className = 'checkform-msg-error';

			// Création du message texte
			var new_txt = document.createTextNode(txt);
			new_node.appendChild(new_txt);
		}

		for (var i in this.msgAttributes) {
			if(i != 'undefined') {
				new_node.setAttribute(i,this.msgAttributes[i]);
			}
		}

		if(this.idMsg !== null && this.isImgDisplay === false) {
			var cur_node = this.$(this.idMsg);
			cur_node.appendChild(new_node,cur_node);
		} else {
			var cur_node = this.$(this.c[n]);
			this.insertAfter(new_node,cur_node);
		}

		/*
		FEATURED
		if(this.closeButton !== false) {
			var close_node = document.createElement('span');
			close_node.id = this.fid+'-checkform-close-button-'+n;
			var close_txt = document.createTextNode('x');
			close_node.appendChild(close_txt);
			new_node.appendChild(close_node,new_node);
		}
		*/

		//colorisation du champ
		this.colorize(n,true);
	},

	//desc 	colorise le champ en fonction de l'état
	colorize: function (n, state) {
		if(typeof(this.$(this.c[n])) === 'undefined') { return false; }

		if (state) {
			this.$(this.c[n]).style.backgroundColor = this.errorColor;
		}
		else {
			this.$(this.c[n]).style.backgroundColor = this.validateColor;
		}
	},


	//desc 	montre des erreur de code en alert si le debuggage est actif
	showError: function (msg) {
		if (this.debug) { alert(msg); }
	},


	/* ***** SYSTEM FUNCTIONS ****** */

	//@n	 	numéro de règle
	//desc	retourne true si l'élément est required
	isRequired: function(n) {
		var loc_reg = this.parseReg(this.r[n]);

		if (loc_reg.length !== 0)
		{
			for(i in loc_reg) {
				if(typeof(loc_reg[i]) == 'string') {
					if ( loc_reg[i] == 'required' ) { return true; }
				}
			}
		}
		return false;
	},

	//@chp 	identifiant du champs
	//desc	retourne la position dans le tableau des reg d'un élement
	getNumReg : function(chp) {
		for(var i = 0, sz = this.c.length; i < sz ; ++i) {
			if(this.c[i] == chp) { return i; }
		}

		return false;
	},

	//@reg 	string
	//desc 	retourne un tableau contenant (la ou) les différentes règles demandées
	existAuthorizedReg : function (n) {
		var loc_reg = this.parseReg(this.r[n]);

		if (loc_reg.length !== 0)
		{
			for(i in loc_reg) {
				if ( typeof(this.authorized[loc_reg[i]]) !== 'undefined' ) { return true;}
			}
		}

		return false;
	},

	//@reg 	string
	//desc 	retourne un tableau contenant (la ou) les différentes règles demandées
	parseReg : function (reg) {
		return reg.split(this.regSeparator);
	},


	//@elem	string (id ou name d'un élément)
	//desc	cette fonction n'est pas l'équivalent de la classe de celle de prototype mais permet de récupérer un élement
	//		par son id si il existe sinon par son name le premier name = elem du document
	$ 	: function (elem) {

		if (document.getElementById(elem) !== null) {
			return document.getElementById(elem);
		}
		else if (typeof(document.getElementsByName(elem)) != 'undefined'){
			return document.getElementsByName(elem)['0'];
		}
		else {
			return null;
		}
	},

	//@new_node	xml node (noeud à insérer)
	//@node		xml node (noeud cible)
	//desc		cette fonction "simule" une fonction insertAfter
	insertAfter : function (new_node, node) {
		//on determine le noeud parent
		var parent_node = node.parentNode.parentNode;
		//on determine le noeud suivant
		var next_node = node.parentNode.nextSibling;
		//si il y a des lignes blanches entre les deux (3 = text)
		/*while(next_node.nodeType == 3 && next_node.nextSibling !== null) {
			try
			{
				//next_node = next_node.nextSibling;
			}
			catch(e)
			{
				showError(e);
			}

		}*/

		try
		{
			//si le noeud suivant n'existe pas cela signifie que node est le dernier est donc il suffit de faire un appendChild de parent_node
			if (next_node === null) {
				parent_node.appendChild(new_node,parent_node);
			}
			else {
				parent_node.insertBefore(new_node,next_node);
			}
		}
		catch(e)
		{
			showError(e);
		}
	},

	//http://www.truerwords.net/articles/web-tech/custom_events.html
	addEventListener : function ( element, event_name, observer, capturing ) {
        if ( element.addEventListener ) {  // the DOM2, W3C way
            element.addEventListener( event_name, observer, capturing );
		}
        else if ( element.attachEvent ) {  // the IE way
            element.attachEvent( "on" + event_name, observer );
		}
    },

	removeEventListener : function ( element, event_name, observer, capturing ) {
        if ( element.removeEventListener ) {  // the DOM2, W3C way
            element.removeEventListener( event_name, observer, capturing );
		}
        else if ( element.detachEvent ) {  // the IE way
            element.detachEvent( "on" + event_name, observer );
		}
    },

	//http://fn-js.info/snippets/bind
	//desc	cette fonction permet de propager un objet dans un environnement où il ne devrait normalement plus exister !!!!
	bind : function (obj, fun, args) {
		return function() {
		if (obj === true) {
			obj = this;
		}
		var f = typeof fun === "string" ? obj[fun] : fun;

		return f.apply(obj, Array.prototype.slice.call(args || [])
			.concat(Array.prototype.slice.call(arguments)));
		};
	}
};
