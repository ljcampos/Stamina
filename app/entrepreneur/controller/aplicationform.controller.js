(function() {
	'use strict';
	angular.module('entrepreneur').controller('AplicationFormController', ['$scope', 'UniversityService',
		'$filter', 'UserService', 'AnnouncementService', 'ApplicationFormAnswer', AplicationFormController]);

	function AplicationFormController($scope, UniversityService, $filter, UserService, AnnouncementService,
	ApplicationFormAnswer) {
		// buttons disables by default
		// $scope.btnSection1 = true;
		// $scope.btnSection2 = true;
		// $scope.btnSection3 = true;
		// $scope.btnSection4 = true;
		// $scope.btnSection5 = true;
		// $scope.btnSection6 = true;
		// $scope.btnSection7 = true;
		$scope.user = UserService.getUser();

		// sections objects
		$scope.objSection1 			= {};
		$scope.objSection2 			= {};
		$scope.objSection20prima 	= "";
		$scope.objSection3 			= {};
		$scope.objSection4 			= {};
		$scope.objSection5 			= {};
		$scope.objSection6 			= {};
		$scope.objSection7 			= {};
		$scope.objSectionEquipo 	= {}; //objSection2.a22.selected.name=='Sí, tengo un equipo para el proyecto'

		// default selected data
		$scope.objSection2.a5 = {
			options: [
			{'id': '2','name' :'Elija una opción'},
				{'id':'0', 'name': 'masculino'},
				{'id': '1','name' :'femenino'}
			],
			selected: {'id': '2','name' :'Elija una opción'}
		};

		$scope.objSection2.a22 = {
			options: [
			{'id': '2','name' :'Elija una opción'},
				{'id':'0', 'name': 'Sí, tengo un equipo para el proyecto'},
				{'id': '1','name' :'No, tengo un equipo para el proyecto'}
			],
			selected: {'id': '2','name' :'Elija una opción'}
		};

		$scope.tabs = [{
				'title': 'Sección #1',
				'target': '#tab_1',
				'targetId': 1,
				'class': 'active',
				'subClass': '',
				//'current': true
			}, {
				'title': 'Sección #2',
				'target': '#tab_2',
				'targetId': 2,
				//'class': 'disable',
				//'subClass': 'disabledTab',
				//'current': false
			}, {
				'title': 'Sección #3',
				'target': '#tab_3',
				'targetId': 3,
				//'class': 'disable',
				//'subClass': 'disabledTab',
				//'current': false
			}, {
				'title': 'Sección #4',
				'target': '#tab_4',
				'targetId': 4,
				//'class': 'disable',
				//'subClass': 'disabledTab',
				//'current': false
			}, {
				'title': 'Sección #5',
				'target': '#tab_5',
				'targetId': 5,
				//'class': 'disable',
				//'subClass': 'disabledTab',
				//'current': false
			}, {
				'title': 'Sección #6',
				'target': '#tab_6',
				'targetId': 6,
				/*'class': 'disable',
				'subClass': 'disabledTab',*/
				//'current': false
		}];

		$scope.init = function() {
			loadData($scope.user.data.roles[0].pivot.user_id);
			//loadAnswers($scope.idEntreneurConvocatory);
		};

		angular.element(document).ready(function() {
			$scope.init();
			/*if($scope.objSection2.a5.selected.id==){
			}
			$("#btn-agregar-miembro").hide();*/
		});
		
		function loadAnswers(id_emprendedor_convocatoria){
			ApplicationFormAnswer.getAnswers(id_emprendedor_convocatoria) 
			.then(function(response) {
				var res = [];
				var index=0;
				var valor = ""; var llave;
				console.log(response);
				for(var i = 0; i < response.data.length; i++) {
					//console.log(response.data[i]);
					angular.forEach(response.data[i], function(value, key) {
						//console.log(response.data[i].a1);
						switch(value){
							case 1:
								$scope.objSection2.a1 = response.data[i].a1;
							break;
							case 2:
								$scope.objSection2.a2 = response.data[i].a2;
							break;
							case 3:
								$scope.objSection2.a3 = response.data[i].a3;
							break;
							/*case 4:
								$scope.objSection2.a4 = $filter('date')(response.data[i].a4, 'dd-MM-yyyy');
							break;*/
							case 5:
								$scope.objSection2.a5.selected = {'name': response.data[i].a5};
							break;
							case 6:
								$scope.objSection2.a6 = response.data[i].a6;
							break;
							case 7:
								$scope.objSection2.a7 = response.data[i].a7;
							break;
							case 8:
								$scope.objSection2.a8 = response.data[i].a8;
							break;
							case 9:
								$scope.objSection2.a9 = response.data[i].a9;
							break;
							case 10:
								$scope.objSection2.a10 = response.data[i].a10;
							break;
							case 11:
								$scope.objSection2.a11 = response.data[i].a11;
							break;
							case 12:
								$scope.objSection2.a12 = response.data[i].a12;
							break;
							case 13:
								$scope.objSection2.a13 = response.data[i].a13;
							break;
							case 14:
								$scope.objSection2.a14 = response.data[i].a14;
							break;
							case 15:
								$scope.objSection2.a15 = response.data[i].a15;
							break;
							case 16:
								$scope.objSection2.a16 = response.data[i].a16;
							break;
							case 17:
								$scope.objSection2.a17 = response.data[i].a17;
							break;
							case 18:
								$scope.objSection2.a18 = response.data[i].a18;
							break;
							case 19:
								$scope.objSection2.a19 = response.data[i].a19;
							break;
							case 20:
								if(
									response.data[i].a20=="Internet de las Cosas (IoT)"||
									response.data[i].a20=="Comercio electrónico (e-commerce)"||
									response.data[i].a20=="Salud (Healt Informatics )"||
									response.data[i].a20=="Wearables Tecnhology"||
									response.data[i].a20=="Educación (Ed Tech)"||
									response.data[i].a20=="Energía & Tecnologías Sustentables ( Clean Tech)"||
									response.data[i].a20=="Finanzas (FinTech)"||
									response.data[i].a20=="Video Juegos"||
									response.data[i].a20=="Salud & Biotecnología"||
									response.data[i].a20=="IT & Software"||
									response.data[i].a20=="Mobile & Wireless"||
									response.data[i].a20=="Recursos Naturales - minería, alimentos, etc."||
									response.data[i].a20=="Media"||
									response.data[i].a20=="Empresa Social"||
									response.data[i].a20=="Social Media/Social Network"||
									response.data[i].a20=="Turismo"
								){
									$scope.objSection2.a20 = response.data[i].a20;
								}else{
									$scope.objSection2.a20 = "Otro (Especifica)";
									$scope.objSection20prima = response.data[i].a20;
								}

							break;
							case 21:
								$scope.objSection2.a21 = response.data[i].a21;
							break;
							case 22:
								$scope.objSection2.a22.selected = {'name': response.data[i].a22};
							break;
							case 23:
								$scope.objSection2.a23 = response.data[i].a23;
							break;
							case 24:
								$scope.objSection2.a24 = response.data[i].a24;
							break;
							case 25:
								$scope.objSection2.a25 = response.data[i].a25;
							break;
							case 26:
								$scope.objSection2.a26 = response.data[i].a26;
							break;
							case 27:
								$scope.objSection2.a27 = response.data[i].a27;
							break;
							case 28:
								$scope.objSection2.a28 = response.data[i].a28;
							break;
							case 29:
								$scope.objSection2.a29 = response.data[i].a29;
							break;
							case 30:
								$scope.objSection2.a30 = response.data[i].a30;
							break;
							case 31:
								$scope.objSection2.a31 = response.data[i].a31;
							break;
							case 32:
								$scope.objSection2.a32 = response.data[i].a32;
							break;
							case 34:
								$scope.objSection2.a34 = response.data[i].a34;
							break;
							case 35:
								$scope.objSection2.a35 = response.data[i].a35;
							break;
							case 36:
								$scope.objSection2.a36 = response.data[i].a36;
							break;
							case 37:
								$scope.objSection2.a37 = response.data[i].a37;
							break;
						}
						/*if (key.substring(1)==1) {
							$scope.objSection2.a1 = value;
						}*/
					});
				}
				/*angular.forEach(response.data, function(value, key) {
					console.log(value);
				});*/
				/*angular.forEach(response.data, function(value, key) {
					valor = value.a1;
					console.log(a1, valor);
				});*/
				//console.log(response.data);
			})
			.catch(function(error) {
				console.log(error);
			});
			console.log("/////////////////////");
			//console.log($scope.objSection2);
		}

		function loadData(id_user) {
			AnnouncementService.validAnnouncementApplied(id_user) ///usuario/{usuario_id}/convocatorias/
			.then(function(response) {
				$scope.idEntreneurConvocatory = response.data[0].id;
				
				loadAnswers(response.data[0].id); //CARGANDO RESPUESTAS
				
				//console.log(response);
				UserService.getUserById(id_user)
				.then(function(res) {
					//console.log(res);
				})
				.catch(function(err) {
					console.log(err);
				});
			})
			.catch(function(error) {
				console.log(error);
			});
			// UniversityService.getAllUniversities()
			// .then(function(response) {
			// 	$scope.data = response.data;
			// })
			// .catch(function(error) {
			// 	console.log(error);
			// });
			//$scope.objSection1.a5.selected = {'name': 'Elija una opción'};
		}

		$scope.saveSection = function(data, formNumber) {
			//console.log(data, formNumber);
			var sizeComplete = false;
			var formDataComplete = false;
			var dataSize = getObjectSize(data);
			

			sizeComplete = validateFormSection(dataSize, formNumber);
			formDataComplete = validateFormData(data);

			// fomat the date
			// if ('birthdate' in data) {
			// 	var dateFormated = $filter('date')(data.birthdate, "dd-MM-yyyy");
			// 	data.birthdate = dateFormated;
			// 	console.log(data.birthdate);
			// }
			if (sizeComplete) {
				console.log('completo');
				if (formNumber < 6)
					activeTab(getTab(formNumber + 1));
					//VERIFICAR FUNCION, Y ADECUAR AL NUEVO PANORAMA...
				setService(formNumber, data, dataSize); 
			} else {
				console.log('no completo');
				setService(formNumber, data, dataSize); 
			}
		};

		/*$scope.$watch('a4', function (newValue) {
			$scope.objSection1.a4 = $filter('date')(newValue, 'dd-MM-yyyy');
		});*/

		function getTab(targetId) {
			var result;
			angular.forEach($scope.tabs, function(value, key) {
				if (value.targetId === targetId) {
					result = value;
				}
			});
			return result;
		}

		function activeTab(tab) {
			tab.class = '';
			tab.subClass = '';
		}

		// $scope.next = function() {
		// 	console.log('next');
		// };

		// validate obj size
		function getObjectSize(data) {
			var size = 0;
			var i;

			for (i in data) {
				if (data.hasOwnProperty(i)) {
					size++;
				}
			}

			return size;
		}

		function validateFormData(data) {
			console.log('data', data);
		}

		function setService(formNumber, formData, dataSize) {
			console.log(dataSize);

			switch(formNumber) {
				case 1:
					console.log(formData);
					console.log("//////////////////////////////////////////");
					angular.forEach(formData, function(value, key) {
						//PONER VALIDACION DE CAPO FECHA, y GÉnero
						var data = {};
						//console.log(key.substring(1), value);
						data.id_pregunta = key.substring(1);
						if (key.substring(1)==4) {
							data.respuesta = $filter('date')(value, 'dd-MM-yyyy');
						}else if(key.substring(1)==5){
							if(value.selected.name!="Elija una opción"){
								data.respuesta = value.selected.name;
							}else{
								data.respuesta = " ";
							}
						}else{
							data.respuesta = value;
						}
						data.calificacion_final = " ";
						data.comentario_final = " ";
						data.id_emprendedor_convocatoria = $scope.idEntreneurConvocatory;

						console.log(data);
						//SERVICE SAVE()
						ApplicationFormAnswer.addSection(data)
						.then(function(response) {
							console.log(response);
						})
						.catch(function(error) {
							console.log(error);
						});
					});
					//console.log(data);
					/*for(var i= 0; i < dataSize; i++) {
						var data = {};
						data.id_pregunta = objSection1r.answer+'i'+1;
						data.respuesta = '';
						data.calificacion_final = 0;
						data.comentario_final = '';
						data.id_emprendedor_convocatoria = $scope.idEntreneurConvocatory;
					}*/
					// ApplicationFormAnswer.addSection(data)
					// .then(function(response) {
					// 	console.log(response);
					// })
					// .catch(function(error) {
					// 	console.log(error);
					// });
					break;
				case 2:
					angular.forEach(formData, function(value, key) {
						var data = {};
						var saltar = 0;
						if((key.substring(1)==20)&&angular.equals(value,"Otro (Especifica)")){
							data.respuesta = $scope.objSection20prima;
							data.id_pregunta = key.substring(1);
						}else{
							data.respuesta = value;
							data.id_pregunta = key.substring(1);
						}
						data.calificacion_final = " ";
						data.comentario_final = " ";
						data.id_emprendedor_convocatoria = $scope.idEntreneurConvocatory;
						//SERVICE SAVE()
						console.log(data);
						ApplicationFormAnswer.addSection(data)
						.then(function(response) {
							console.log(response);
						})
						.catch(function(error) {
							console.log(error);
						});
					});
					// ApplicationFormAnswer.addSection(data)
					// .then(function(response) {
					// 	console.log(response);
					// })
					// .catch(function(error) {
					// 	console.log(error);
					// });
					break;
				case 3:
					angular.forEach(formData, function(value, key) {
						var data = {};
						var saltar = 0;
						if(key.substring(1)==22){
							if(value.selected.name!="Elija una opción"){
								data.respuesta = value.selected.name;
							}else{
								data.respuesta = " ";
							}
						}else{
							data.respuesta = value;
						}
						data.id_pregunta = key.substring(1);
						data.calificacion_final = " ";
						data.comentario_final = " ";
						data.id_emprendedor_convocatoria = $scope.idEntreneurConvocatory;
						//SERVICE SAVE()
						console.log(data);
						ApplicationFormAnswer.addSection(data)
						.then(function(response) {
							console.log(response);
						})
						.catch(function(error) {
							console.log(error);
						});
					});
					// ApplicationFormAnswer.addSection(data)
					// .then(function(response) {
					// 	console.log(response);
					// })
					// .catch(function(error) {
					// 	console.log(error);
					// });
					break;
				case 4:
					angular.forEach(formData, function(value, key) {
						var data = {};
						var saltar = 0;
						data.respuesta = value;
						data.id_pregunta = key.substring(1);
						data.calificacion_final = " ";
						data.comentario_final = " ";
						data.id_emprendedor_convocatoria = $scope.idEntreneurConvocatory;
						//SERVICE SAVE()
						console.log(data);
						ApplicationFormAnswer.addSection(data)
						.then(function(response) {
							console.log(response);
						})
						.catch(function(error) {
							console.log(error);
						});
					});
					// ApplicationFormAnswer.addSection(data)
					// .then(function(response) {
					// 	console.log(response);
					// })
					// .catch(function(error) {
					// 	console.log(error);
					// });
					break;
				case 5:
					angular.forEach(formData, function(value, key) {
						var data = {};
						var saltar = 0;
						/*if((key.substring(1)==20)&&angular.equals(value,"Otro (Especifica)")){
							data.respuesta = $scope.objSection20prima;
							data.id_pregunta = key.substring(1);
						}else{*/
						data.respuesta = value;
						data.id_pregunta = key.substring(1);
						data.calificacion_final = " ";
						data.comentario_final = " ";
						data.id_emprendedor_convocatoria = $scope.idEntreneurConvocatory;
						//SERVICE SAVE()
						console.log(data);
						ApplicationFormAnswer.addSection(data)
						.then(function(response) {
							console.log(response);
						})
						.catch(function(error) {
							console.log(error);
						});
					});
					break;
				case 6:
					// ApplicationFormAnswer.addSection(data)
					// .then(function(response) {
					// 	console.log(response);
					// })
					// .catch(function(error) {
					// 	console.log(error);
					// });
					angular.forEach(formData, function(value, key) {
						var data = {};
						var saltar = 0;
						/*if((key.substring(1)==20)&&angular.equals(value,"Otro (Especifica)")){
							data.respuesta = $scope.objSection20prima;
							data.id_pregunta = key.substring(1);
						}else{*/
						data.respuesta = value;
						data.id_pregunta = key.substring(1);
						data.calificacion_final = " ";
						data.comentario_final = " ";
						data.id_emprendedor_convocatoria = $scope.idEntreneurConvocatory;
						//SERVICE SAVE()
						console.log(data);
						ApplicationFormAnswer.addSection(data)
						.then(function(response) {
							console.log(response);
						})
						.catch(function(error) {
							console.log(error);
						});
					});
					break;
				default:
					console.log('No existe el formulario.');
			}
		}

		function validateFormSection(dataSize, formNumber) {
			switch(formNumber) {
				case 1:
					if (dataSize === 10)
						return true;
					break;
				case 2:
					if (dataSize >= 11)
						return true;
					break;
				case 3:
					if (dataSize === 9)
						return true;
					break;
				case 4:
					if (dataSize === 4)
						return true;
					break;
				case 5:
					if (dataSize >= 6)
						return true;
					break;
				case 6:
					console.log(formNumber);
					if (dataSize === 2)
						return true;
					break;
				default:
					console.log('No existe el formulario.');
			}
		}

		angular.element(document).ready(function() {
			$scope.init();
		});
	}
})();