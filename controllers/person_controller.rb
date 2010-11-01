class PersonController < ApplicationController
  def index
    redirect_to :action=>"list"
  end

  def list
    @people = Person.find(:all)
  end

  def new
    @person = Person.new params[:person]
    @person.save
    redirect_to :action=>'list'
  end

  def swap
    session[:person_id] = params[:id]
    @redirect_url = params[:redirect_url]
    redirect_to @redirect_url
  end

  def revenues_expenses
    @person = current_user_or_first
    if request.post?
      @from_date = Date.strptime(params[:from_date], '%Y-%m-%d')
      @to_date = Date.strptime(params[:to_date], '%Y-%m-%d')
    elsif params[:from_year] and params[:from_month] and params[:from_day] and params[:to_year] and params[:to_month] and params[:to_day]
      @from_date = Date.new(params[:from_year].to_i, params[:from_month].to_i, params[:from_day].to_i)
      @to_date = Date.new(params[:to_year].to_i, params[:to_month].to_i, params[:to_day].to_i)
    end
    if (@from_date && @to_date)
      @entries = @person.entries.find(:all, :conditions=>["date BETWEEN ? and ?",@from_date.to_s(:db),@to_date.to_s(:db)])
    else
      @entries = @person.entries
    end
    @entries.sort!{|a,b| a.date <=> b.date}
    @debts = @person.debts
  end

  def cash_flow
    @person = current_user_or_first
    @accounts = @person.bank_accounts
    if request.post?
      @from_date = Date.strptime(params[:from_date], '%Y-%m-%d')
      @to_date = Date.strptime(params[:to_date], '%Y-%m-%d')
    end
    @entries = []
    @beginning_balance_total = 0
    @accounts.each do |account|
      if request.post?
        @entries.concat account.entries.find(:all, :conditions=>["date BETWEEN ? and ?",@from_date.to_s(:db),@to_date.to_s(:db)])
      else
        @entries.concat account.entries
      end
      @beginning_balance_total += account.beginning_balance.to_f
    end
    @entries.sort!{|a,b| a.date <=> b.date}
  end
  
  def networth
    @graph = open_flash_chart_object(900,500, '/person/networthchart', true, '/')
  end
  
  def networthchart
    person = current_user_or_first
    bar = BarOutline.new(50, '#9933CC', '#8010A0')
    bar.key("Page VIEWS", 10)
    
    labels = []
    max = 0
    (0..12).to_a.reverse.each do |i|
      labels << i.months.ago.to_date.to_s
      networth = person.networth(i.months.ago.to_date)
      bar.data << networth
      max = networth if networth > max
    end

    g = Graph.new
    g.title("BAR CHART", "{font-size: 15px;}")
    
    g.data_sets << bar
    g.set_x_labels(labels)
    
    g.set_x_label_style(10, '#9933CC', 0,2)
    g.set_x_axis_steps(2)
    g.set_y_max(max * 1.10)
    g.set_y_label_steps(4)
    g.set_y_legend("OPENF LADF", 12, "#736AFF")
    render :text => g.render
  end
  
  def revenuesexpenseschart
    @graph = open_flash_chart_object(900,500, '/person/revenuesexpenseschartdata', true, '/')
  end
  
  def revenuesexpenseschartdata
    person = current_user_or_first
    bar1 = Bar.new(50, '#0066CC')
    bar1.key('Revenues', 10)
    
    bar2 = Bar.new(50, '#9933CC')
    bar2.key('Expenses', 10)
    
    max = 0
    labels = []
    (0..11).to_a.reverse.each do |i|
      expenses = person.expenses((i+1).months.ago.to_date, i.months.ago.to_date)
      revenues = person.revenues((i+1).months.ago.to_date, i.months.ago.to_date)
      labels << (i+1).months.ago.to_date.month.to_s
      bar1.data << revenues
      bar2.data << expenses
      max = expenses if expenses > max
      max = revenues if revenues > max
    end
    
    g = Graph.new
    g.title("Bar Graph", "{font-size: 26px;}")
    
    g.data_sets << bar1
    g.data_sets << bar2
    
    g.set_x_labels(labels)
    g.set_x_label_style(10, '#9933CC', 0, 2)
    g.set_x_axis_steps(2)
    g.set_y_max(max * 1.10)
    g.set_y_label_steps(2)
    g.set_y_legend("Open Flash Chart", 12, "0x736AFF")
    render :text => g.render
  end
end
