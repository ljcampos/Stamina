(function() {
	'use strict';
	angular.module('announcement').service('AnnouncementService', ['$q', '$http', 'API', AnnouncementService]);
	function AnnouncementService($q, $http, API) {
		return {
			getAllUniversities: getAllUniversities,
			validAnnouncementApplied: validAnnouncementApplied,
			getAllAnnouncements: getAllAnnouncements,
			getAnnouncementsAvailable: getAnnouncementsAvailable,
			getAnnouncementById: getAnnouncementById,
			getAnnouncementsNext: getAnnouncementsNext,
			getAnnouncementsPast: getAnnouncementsPast,
			addAnnouncement: addAnnouncement,
			editAnnouncement: editAnnouncement,
			deleteAnnouncement: deleteAnnouncement
		};
		function validAnnouncementApplied(id) {
			var userDefer = $q.defer();
			$http.get(API.announcement.entrepreneur_announce.replace(':id', id))
			.success(function(response) {
				userDefer.resolve(response);
			})
			.error(function(error) {
				userDefer.reject(error);
				//console.log(error);
			});
			return userDefer.promise;
		}
		function getAllUniversities() {
			var universityDefer = $q.defer();
			$http.get(API.university.list)
			.success(function(response) {
				universityDefer.resolve(response);
			})
			.error(function(error) {
				universityDefer.reject(error);
				//console.log(error);
			});
			return universityDefer.promise;
		}
		function getAllAnnouncements() {
			var announcementDefer = $q.defer();
			$http.get(API.announcement.list)
			.success(function(response) {
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				//console.log(error);
			});
			return announcementDefer.promise;
		}
		function getAnnouncementsAvailable() {
			var announcementDefer = $q.defer();
			$http.get(API.announcement.aviable)
			.success(function(response) {
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				//console.log(error);
			});
			return announcementDefer.promise;
		}
		function getAnnouncementsNext() {
			var announcementDefer = $q.defer();
			$http.get(API.announcement.next)
			.success(function(response) {
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				//console.log(error);
			});
			return announcementDefer.promise;
		}
		function getAnnouncementsPast() {
			var announcementDefer = $q.defer();
			$http.get(API.announcement.past)
			.success(function(response) {
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				//console.log(error);
			});
			return announcementDefer.promise;
		}
		function getAnnouncementById(id) {
			var announcementDefer = $q.defer();
			$http.get(API.announcement.ById.replace(':id', id))
			.success(function(response) {
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				//console.log(error);
			});
			return announcementDefer.promise;
		}
		function addAnnouncement(data) {
			var announcementDefer = $q.defer();
			$http.post(API.announcement.add, data)
			.success(function(response) {
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				//console.log(error);
			});
			return announcementDefer.promise;
		}
		function editAnnouncement(data) {
			var announcementDefer = $q.defer();
			$http.put(API.user.add, data)
			.success(function(response) {
				announcementDefer.resolve(response);
			})
			.error(function(error) {
				announcementDefer.reject(error);
				//console.log(error);
			});
			return announcementDefer.promise;
		}
		function deleteAnnouncement(id) {
			var announceDefer = $q.defer();
			$http.post(API.announcement.delete.replace(':id', id))
			.success(function(response) {
				announceDefer.resolve(response);
			})
			.error(function(error) {
				announceDefer.reject(error);
				//console.log(error);
			});
			return announceDefer.promise;
		}
	}
} ());