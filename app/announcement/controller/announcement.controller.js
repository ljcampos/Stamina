(function() {
	'use strict';

	angular.module('announcement').controller('AnnouncementController', ['$scope', 'AnnouncementService', AnnouncementController]);

	function AnnouncementController($scope, AnnouncementService) {
		$scope.text = 'xsdfsf';
		$scope.announcesList = {};
		$scope.announcesAvailableList = {};
		$scope.announcesNextList = {};
		$scope.announcesPastList = {};
		
		$scope.init = function() {
			getAnnouncements();
			getAnnouncementsAvailable();
			getAnnouncementsNext();
			getAnnouncementsPast();
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