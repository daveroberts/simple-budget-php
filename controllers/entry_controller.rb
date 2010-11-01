class EntryController < ApplicationController
	def new
		account = BankAccount.find params[:account_id]
		entry = Entry.new(params[:entry])
		entry.save
		account.entries << entry
		account.save
		flash[:notice] = "Entry saved to account"
		redirect_to :controller=>"account", :action=>'cash_flow', :person_id=>account.owner.id, :id=>account.id
	end

	def edit
		@entry = Entry.find(params[:id])
    @redirect_url = params[:redirect_url]
    render :layout=>'basic'
	end

	def update
		params[:entry][:person_ids] ||= []
		entry = Entry.find(params[:id])
		entry.update_attributes(params[:entry])
		entry.save
		flash[:notice] = "Entry updated"
    @redirect_url = params[:redirect_url]
    redirect_to @redirect_url
	end

	def delete
		account = BankAccount.find params[:account_id]
		entry = Entry.find(params[:id])
		entry.destroy
		flash[:notice] = "Entry deleted"
		redirect_to :controller=>"account", :action=>'cash_flow', :person_id=>account.owner.id, :id=>account.id
	end
end
