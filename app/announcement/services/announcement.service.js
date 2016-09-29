(function() {
	'use strict';

	angular.module('announcement').service('AnnouncementService', ['$q', '$http', AnnouncementService]);

	function AnnouncementService($q, $http) {
		return {
			getAllUniversities: getAllUniversities,
			getAllAnnouncements: getAllAnnouncements,
			getAnnouncementsAvailable: getAnnouncementsAvailable,
			getAnnouncementById: getAnnouncementById,
			addAnnouncement: addAnnouncement,
			editAnnouncement: editAnnouncement,
			deleteAnnouncement: deleteAnnouncement

		};

		function getAllUniversities() {
			var universityDefer = $q.defer();
			$http.get('http://www.stamina.dev/API/public/api/v1/universidad/')
			.success(function(response) {
				universityDefer.resolve(response);
			})
			.error(function(error) {
				universityDefer.reject(error);
				console.log(error);
			});
			return universityDefer.promise;
		}

		function getAllAnnouncements() {
			var announcementDefer = $q.defer();

			$http.get('http://www.stamina.dev/API/public/api/v1/convocatoria/')
			.success(function(response) {
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				console.log(error);
			});

			return announcementDefer.promise;
		}
		function getAnnouncementsAvailable() {
			var announcementDefer = $q.defer();

			$http.get('http://www.stamina.dev/API/public/api/v1/convocatoria/actuales/')
			.success(function(response) {
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

			$http.get('http://www.stamina.dev/API/public/api/v1/convocatoria/'+id+'/')
			.success(function(response) {
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

			$http.post('http://www.stamina.dev/API/public/api/v1/convocatoria/', data)
			.success(function(response) {
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				console.log(error);
			});

			return announcementDefer.promise;
		}

		function editAnnouncement(data) {
			var announcementDefer = $q.defer();
			$http.put('http://www.stamina.dev/API/public/api/v1/usuario/', data)
			.success(function(response) {
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