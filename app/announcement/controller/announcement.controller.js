(function() {
	'use strict';

	angular.module('announcement').controller('AnnouncementController', ['$scope', 'AnnouncementService', AnnouncementController]);

	function AnnouncementController($scope, AnnouncementService) {
		$scope.text = 'xsdfsf';
		$scope.userList = null;
		
		$scope.init = function() {
			getAnnouncements();
		};

		angular.element(document).ready(function() {
			$scope.init();
		});

		function getAnnouncements() {
			AnnouncementService.getAllAnnouncements()
			.then(function(response) {
				console.log(response);
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