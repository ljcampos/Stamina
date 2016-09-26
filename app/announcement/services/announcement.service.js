(function() {
	'use strict';

	angular.module('announcement').service('AnnouncementService', ['$q', '$http', AnnouncementService]);

	function AnnouncementService($q, $http) {
		return {
			getAllAnnouncements: getAllAnnouncements,
			getAnnouncementById: getAnnouncementById,
			addAnnouncement: addAnnouncement,
			updateAnnouncement: updateAnnouncement,
			deleteAnnouncement: deleteAnnouncement

		};

		function getAllAnnouncements() {
			var announcementDefer = $q.defer();

			$http.get('http://www.stamina.dev/API/public/api/v1/convocatoria/')
			.success(function(response) {
				console.log(response);
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				console.log(error);
			});

			return announcementDefer.promise;
		}

		function getAnnouncementById(id) {
			var announcementDefer = $q.defer();

			$http.get('http://www.stamina.dev/API/public/api/v1/usuario/')
			.success(function(response) {
				console.log(response);
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				console.log(error);
			});

			return announcementDefer.promise;
		}

		function addAnnouncement(data) {
			var announcementDefer = $q.defer();

			$http.post('http://www.stamina.dev/API/public/api/v1/usuario/', data)
			.success(function(response) {
				console.log(response);
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				console.log(error);
			});

			return announcementDefer.promise;
		}

		function updateAnnouncement(data) {
			var announcementDefer = $q.defer();
			$http.put('http://www.stamina.dev/API/public/api/v1/usuario/', data)
			.success(function(response) {
				console.log(response);
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				console.log(error);
			});
			return announcementDefer.promise;
		}

		function deleteAnnouncement(id) {
			var announcementDefer = $q.defer();

			$http.delete('http://www.stamina.dev/API/public/api/v1/usuario/', id)
			.success(function(response) {
				console.log(response);
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				console.log(error);
			});

			return announcementDefer.promise;
		}
	}
} ());