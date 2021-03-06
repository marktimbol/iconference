var React = require('react');
var ReactDOM = require('react-dom');
var update = require('react-addons-update');
var _ = require('lodash');
var algoliasearch = require('algoliasearch');

import UserInfo from './UserInfo';
import SearchUser from './SearchUser';

var csrf_token = $('meta[name="csrf_token"]').attr('content');

var index;

var ExhibitorContacts = React.createClass({

	getInitialState()
	{
		return {
			searchKey: '',
			exhibitorContacts: window.exhibitor.contacts,
			availableContacts: [],
		}
	},

	componentDidMount()
	{
		var client = algoliasearch("CU6OGKCO5Z", '9230fbbc6127c4250e0362facfe0f019');
		index = client.initIndex('mecsc_users');

		this.enableTypeahead();
		this.refreshAvailableContacts();
	},

	enableTypeahead()
	{
		$('.typeahead')
			.typeahead({
				minLength: 1,
				highlight: true,
				hint: false,
			}, {
				name: 'users',
				source: index.ttAdapter(),
				displayKey: 'name',
				templates: {
					notFound: function() {
						return (
							'<div class="Suggestion--no-result"><p>No result found.</p></div>'
						)
					},
					suggestion: function(hit) {
						var imagePath = '/dist/img/user1-128x128.jpg';
						return (
							'<div class="Suggestion">' +
								'<div class="Suggestion__figure">' +
									'<img src="'+imagePath+'" class="img-responsive" alt="" title="" />' +
								'</div>' +

								'<div class="Suggestion__content">' +
									'<h3 class="Suggestion__heading">' + hit._highlightResult.name.value + '</h3>' +
									'<address>' +
										'<p>' +
											hit.email +
										'</p>' +
										'<p>' +
											hit.designation + ' at ' + hit.company +
										'</p>' +										
									'</address>' +
								'</div>' +
							'</div>' 
						)
					}
				
				}
			})
			.on('typeahead:select', function(e, suggestion) {
				this.setState({
					searchKey: suggestion.name
				});
			}.bind(this));	
	},

	makeRequest(type, url, data)
	{
		$.ajax({
			url: url,
			type: type,
			data: data,
			headers: {
				'X-CSRF-Token': csrf_token,
			},
			success: function(response) {},
			error: function(xhr, status, err) {
				console.log(err.toString());
			}
		});
	},

	handleChangeSearch(e)
	{
		this.setState({ searchKey: e.target.value });
	},

	searchContact(e)
	{
		e.preventDefault();
		$('.typeahead').typeahead('close');

		index.search(this.state.searchKey, null, function(error, result) {
		  	this.setState({ availableContacts: result.hits });
		}.bind(this), { hitsPerPage: 10, page: 0 });
	},

	refreshAvailableContacts()
	{
		this.setState({ searchKey: '' });

		index.search('', null, function(error, result) {
		  	this.setState({ availableContacts: result.hits });
		}.bind(this), { hitsPerPage: 10, page: 0 });
	},

	addContact(selectedContact)
	{
		this.setState({
			exhibitorContacts: this.state.exhibitorContacts.concat(selectedContact)
		});

		this.refreshAvailableContacts();

		var url = '/dashboard/exhibitors/' + window.exhibitor.id + '/contacts';
		this.makeRequest('POST', url, { 'contact_id': selectedContact.id });
	},

	removeContact(selectedContact)
	{
		var contactIndex = _.findIndex(this.state.exhibitorContacts, function(exhibitorContact) {
		    return exhibitorContact.id == selectedContact.id;
		});

		this.setState({
			exhibitorContacts: update(this.state.exhibitorContacts, {$splice: [[contactIndex, 1]]}),
		});

		this.refreshAvailableContacts();

		var url = '/dashboard/exhibitors/' + window.exhibitor.id + '/contacts/' + selectedContact.id;
		this.makeRequest('DELETE', url, []);
	},

	render()
	{
		var exhibitorContacts = this.state.exhibitorContacts.map(function(exhibitorContact) {
			var url = '/dashboard/users/' + exhibitorContact.id;
			return (
				<UserInfo 
					key={exhibitorContact.id}
					user={exhibitorContact}
					url={url}
					action={'remove'}
					showAddButton={false}
					onDelete={this.removeContact} />
			);
		}.bind(this));		

		var availableContacts = this.state.availableContacts.map(function(availableContact) {
			var isPartOfThisExhibitor = false;
			this.state.exhibitorContacts.map(function(exhibitorContact) {
				if( exhibitorContact.id === availableContact.id ) {
					isPartOfThisExhibitor = true;
				}
			});

			var url = '/dashboard/users/' + availableContact.id;
			return (
				<UserInfo 
					key={availableContact.id}
					user={availableContact}
					url={url}
					showAddButton={!isPartOfThisExhibitor}
					onSave={this.addContact} />
			);
		}.bind(this));

		return (
			<div className="Users">
				<h3>Contacts ({exhibitorContacts.length})</h3>
				<ul className="list-group">
         			{exhibitorContacts}
				</ul>

				<h3>Available Contacts</h3>
				<SearchUser 
					onSubmit={this.searchContact}
					value={this.state.searchKey}
					placeholder={'Search Contacts'}
					onChange={this.handleChangeSearch} />

				<ul className="list-group">
         			{availableContacts}
				</ul>
			</div>
		)
	}
});

ReactDOM.render(
	<ExhibitorContacts />,
	document.getElementById('ExhibitorContacts')
);