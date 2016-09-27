(function() {
	'use strict';

	angular.module('announcement').controller('AnnouncementAddController', ['$scope', 'AnnouncementService', AnnouncementAddController]);

	function AnnouncementAddController($scope, AnnouncementService) {
		$scope.text = 'xsdfsf';
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

		$scope.addAnnouncement = function(announce) {
			var data = {};

			data.nombre 			=	announce.nombre;
			data.universidad_id 	=	announce.universidad;
			data.path 				=	"stamina_convocatoria.pdf";
			data.fecha_inicio 		=	"2016-10-04";
			data.fecha_cierre 		=	"2016-12-14";

			AnnouncementService.addAnnouncement(data)
			.then(function(response) {
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
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