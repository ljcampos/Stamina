(function() {
	'use strict';

	angular.module('announcement').controller('AnnouncementEditController', ['$state', '$stateParams', '$scope', 'AnnouncementService', 'Upload', AnnouncementEditController]);

	function AnnouncementEditController($state, $stateParams, $scope, AnnouncementService, Upload) {
		$scope.text = 'xsdfsf';
		$scope.announce = {};
		$scope.announceID = {};
		$scope.univesityList = {};
		$scope.selected_universidad = {};
		
		$scope.init = function() {
			getAllUniversities();
			getAnnouncementById($stateParams.id);
			$scope.announceID = $stateParams.id;
		};

		angular.element(document).ready(function() {
			$scope.init();
		});

		function getAnnouncementById(id) {
			AnnouncementService.getAnnouncementById(id)
			.then(function(response) {
				$scope.selected_universidad = response.data.universidad.universidad_id;
				$scope.announce = response.data;
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		}
		function getAllUniversities() {
			AnnouncementService.getAllUniversities()
			.then(function(response) {
				console.log(response);
				$scope.univesityList = response.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		}

		$scope.editAnnouncement = function(announce,file) {
			var data = {};
			data.nombre 			=	announce.nombre;
			data.universidad_id 	=	announce.universidad.universidad_id;
			data.fecha_inicio 		=	announce.fecha_inicio;
			data.fecha_cierre 		=	announce.fecha_cierre;
			data.file				=	file;

			file.upload = Upload.upload({
				url: 'http://www.stamina.dev/API/public/api/v1/convocatoria/'+$scope.announceID+'/update/',
				method: 'POST',
				data: data
			})
			.then(function(res) {
				console.log(res);
			})
			.catch(function(err) {
				console.log(err);
			});
		};
	}
} ());