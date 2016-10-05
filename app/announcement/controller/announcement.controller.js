(function() {
	'use strict';

	angular.module('announcement').controller('AnnouncementController', ['$scope', 'AnnouncementService', 'UserService', AnnouncementController]);

	function AnnouncementController($scope, AnnouncementService, UserService) {
		$scope.text = 'xsdfsf';
		$scope.announcesList = {};
		$scope.announcesAvailableList = {};
		$scope.user = UserService.getUser();
		$scope.announcesNextList = {};
		$scope.announcesPastList = {};
		
		$scope.init = function() {
			getAnnouncements();
			getAnnouncementsAvailable();
			getAnnouncementsNext();
			getAnnouncementsPast();
			console.log($scope.user);
		};

		angular.element(document).ready(function() {
			$scope.init();
		});

		function getAnnouncements() {
			AnnouncementService.getAllAnnouncements()
			.then(function(response) {
				$scope.announcesList = response.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		}
		function getAnnouncementsNext() {
			AnnouncementService.getAnnouncementsNext()
			.then(function(response) {
				$scope.announcesNextList = response.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		}
		function getAnnouncementsPast() {
			AnnouncementService.getAnnouncementsPast()
			.then(function(response) {
				$scope.announcesPastList = response.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		}
		function getAnnouncementsAvailable() {
			AnnouncementService.getAnnouncementsAvailable()
			.then(function(response) {
				$scope.announcesAvailableList = response.data;
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

		$scope.addAnnouncement = function() {
			var data = {};
			data.value1 = '';
			data.value2 = '';
			data.value3 = '';
			data.value4 = '';
			data.value5 = '';

			AnnouncementService.addAnnouncement(data)
			.then(function(response) {
				console.log(response);
			})
			.catch(function(error) {
				console.log(error);
			});
		};

		$scope.deleteAnnouncement = function(id) {
			var r = confirm("¿Está seguro de que desea eliminar permanentemente el elemento especificado de la base de datos?");
			if(r){
				AnnouncementService.deleteAnnouncement(id)
				.then(function(response) {
					$scope.init();
					$state.go('admin.announcement.list');
				})
				.catch(function(error) {
					console.log(error);
				});
				console.log("CODIGO ELIMINAR");
			}
		};
	}


} ());