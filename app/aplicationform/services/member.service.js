(function() {
	'use strict';
	angular.module('aplicationform').service('MemberService', ['$q', '$http', 'API', MemberService]);

	function MemberService($q, $http, API) {
		return {
			getMembers: getMembers,
			getMemberById: getMemberById,
			addMember: addMember,
			editMember: editMember,
			deleteMember: deleteMember
		};

		function getMembers() {
			var memberDefer = $q.defer();

			$http.get(API.member.list)
			.success(function(response) {
				console.log(response);
				memberDefer.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				memberDefer.reject(error);
			});
			return memberDefer.promise;
		}

		function getMemberById(id) {
			var memberDefer = $q.defer();

			$http.get(API.member.ById.replace(':id', id))
			.success(function(response) {
				console.log(response);
				memberDefer.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				memberDefer.reject(error);
			});
			return memberDefer.promise;
		}

		function addMember(data) {
			var memberDefer = $q.defer();

			$http.post(API.member.add, data)
			.success(function(response) {
				console.log(response);
				memberDefer.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				memberDefer.reject(error);
			});
			return memberDefer.promise;
		}

		function editMember(data) {
			var memberDefer = $q.defer();

			$http.post(API.member.update.replace(':id', id), data)
			.success(function(response) {
				console.log(response);
				memberDefer.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				memberDefer.reject(error);
			});
			return memberDefer.promise;
		}

		function deleteMember(id) {
			var memberDefer = $q.defer();

			$http.post(API.member.delete.replace(':id', id))
			.success(function(response) {
				console.log(response);
				memberDefer.resolve(response);
			})
			.error(function(error) {
				console.log(error);
				memberDefer.reject(error);
			});
			return memberDefer.promise;
		}

	}
})();