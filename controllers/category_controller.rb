class CategoryController < ApplicationController
  def list
    @tags = Tag.find :all, :order=>"name"
    @newtag = Tag.new
  end
  
  def create
    tag = Tag.new params[:newtag]
    if tag.name == ""
      flash[:notice] = "You must provide a tag name"
    elsif tag.save
      flash[:notice] = tag.name + " created successfully"
    else
      flash[:notice] = "Could not create tag"
    end
    redirect_to :action=>:list
  end
  
  def delete
    tag = Tag.find params[:id]
    if tag != nil
      flash[:notice] = "Removed " + tag.name
      Entry.update_all 'tag_id = NULL', ['tag_id = ' + params[:id].to_s]
      tag.destroy
    else
      flash[:notice] = "Could not find tag #" + params[:id].to_s
    end
    redirect_to :action=>:list
  end
  
  def edit
    @tag = Tag.find(params[:id])
    @redirect_url = params[:redirect_url]
    render :layout=>'basic'
  end
  
  def update
  	tag = Tag.find(params[:id])
  	tag.update_attributes(params[:tag])
  	if tag.save
      flash[:notice] = "Tag updated"
  	else
      flash[:notice] = "Tag could not be updated"
    end
    @redirect_url = params[:redirect_url]
    redirect_to @redirect_url
	end
  
  def breakdown
    @person = current_user_or_first
    @tags = Tag.find(:all).sort{|a,b|a.name<=>b.name}
    @total_time = Date.today - @person.first_entry
    @total_time = @total_time.to_f
    @graph = open_flash_chart_object(600,300, '/category/breakdownchart', true, '/')
  end
  
  def breakdownchart
    person = current_user_or_first
    numbers = []
    names = []
    links = []
    tags = Tag.find(:all).sort{|a,b|a.name<=>b.name}
    for tag in tags
      expenses = person.expenses_by_tag(tag.id)
      if expenses < 0
        numbers << expenses.abs
        names << tag.name
        links << "http://www.google.com"
      end
    end
    
    g = Graph.new
    g.pie(60, '#505050', '{font-size: 12px; color: #404040;}')
    g.pie_values(numbers, names, links)
    g.pie_slice_colors(%w(#d01fc3 #356aa0 #c79810))
    g.set_tool_tip("#val#")
    g.title("Category Breakdown", '{font-size:18px; color: #d01f3c}' )
    render :text => g.render
  end

  def show
    if params[:tag_id].to_i == -1
      redirect_to :action=>"none", :id=>params[:id]
      return
    end
    @person = current_user_or_first
    @tag = Tag.find params[:tag_id]
    @entries = Entry.find(:all, :conditions=>["tag_id = ?", @tag.id], :order=>"date")
    @total = @entries.collect{|entry|entry.share.to_f}.sum
  end

  def none
    @person = current_user_or_first
    @tag = Tag.new(:name=>"Untagged")
    @entries = Entry.find(:all, :conditions=>["(tag_id IS NULL OR tag_id = 0) AND transfer='f'"], :order=>"date")
    @total = @entries.collect{|entry|entry.share.to_f}.sum
    render :action=>:show
  end
end
