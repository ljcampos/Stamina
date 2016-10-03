(function() {
	'use strict';

	angular.module('announcement').controller('AnnouncementAddController', ['$scope', 'AnnouncementService', 'Upload', AnnouncementAddController]);

	function AnnouncementAddController($scope, AnnouncementService, Upload) {
		$scope.text = 'xsdfsf';
		$scope.announce = {};
		$scope.univesityList = {};
		
		$scope.init = function() {
			getAnnouncements();
		};

		angular.element(document).ready(function() {
			$scope.init();
		});

		function getAnnouncements() {
			AnnouncementService.getAllUniversities()
			.then(function(response) {
				console.log(response);
				$scope.univesityList = response.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		}

		$scope.getAnnouncementByID = function() {
			AnnouncementService.getAnnouncementById(id)
			.then(function(response) {
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		};

		$scope.addAnnouncement = function(announce, file) {
			var data = {};

			data.nombre 			=	announce.nombre;
			data.universidad_id 	=	announce.universidad;
			//data.path 				=	"stamina_convocatoria.pdf";
			data.fecha_inicio 		=	announce.fecha_inicio;
			data.fecha_cierre 		=	announce.fecha_final;
			data.file				=	file;

			// console.log(data);

			file.upload = Upload.upload({
				url: 'http://www.stamina.dev/API/public/api/v1/convocatoria/',
				method: 'POST',
				data: data
			})
			.then(function(res) {
				console.log(res);
			})
			.catch(function(err) {
				console.log(err);
			});

			// AnnouncementService.addAnnouncement(data)
			// .then(function(response) {
			// 	console.log(response);
			// })
			// .catch(function(error) {
			// 	console.log(error);
			// });
		};

		$scope.updateAnnouncement = function() {
			var data = {};
			data.value1 = '';
			data.value2 = '';
			data.value3 = '';
			data.value4 = '';
			data.value5 = '';

			AnnouncementService.updateAnnouncement(data)
			.then(function(response) {
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		};

		$scope.deleteAnnouncement = function() {
			AnnouncementService.deleteAnnouncement(id)
			.then(function(response) {
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		};
	}


} ());