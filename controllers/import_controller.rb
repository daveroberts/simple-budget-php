require 'csv'

class ImportController < ApplicationController
	def index
    redirect_to :action=>"csv"
	end

	def csv
    @accounts = BankAccount.find(:all, :order=>"name")
	end

  def select_columns
    @bank_account = params[:account][:id]
    @shared_between = params[:entry][:shared_between]
    @file = CSV::Reader.parse(params[:csvfile]).to_a
		@columns = @file.first.length
  end

	def match_columns
    @bank_account = params[:account]
		@entries = Array.new
		@file = YAML::load params[:file][:file]
		@file.each do |row|
      entry = Entry.new params[:entry]
      params[:column].each do |col,header|
        case header
          when "date": entry.date = row[col.to_i - 1]
          when "description": entry.description = row[col.to_i - 1]
          when "amount": entry.amount = row[col.to_i - 1]
        end
        entry.shared_between = params[:shared_between]
        entry.import = !entry.similar_in_db? && entry.amount.to_f != 0
      end
      entry.expand_descriptions!
			@entries << entry
		end
	end

	def create
    @bank_account = BankAccount.find(params[:account])
		@entries = Array.new
		good = 0
		bad = 0
    for entry_params in params[:entry]
      entry = Entry.new(entry_params[1])
      entry.charged_to = @bank_account
      if entry.import == "1"
        if entry.save
					good = good + 1
        else
					bad = bad + 1
				end
      end
    end
    flash[:notice] = "Entries saved: " + good.to_s + " Entries failed to save: " + bad.to_s
		redirect_to :controller=>:person, :action=>:list
	end
end

