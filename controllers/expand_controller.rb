class ExpandController < ApplicationController
  def index
    redirect_to :action=>"list"
  end

  def list
    @expand = Expand.new
    @expands = Expand.find(:all)
  end

  def create
    expand = Expand.new(params[:expand])
    if expand.save
      flash[:notice] = "New expansion created"
      redirect_to :action=>'list'
    else
      flash[:notice] = "Could not create expansion"
    end
  end

  def delete
    expand = Expand.find params[:id]
    expand.destroy
    flash[:notice] = "Expand deleted"
    redirect_to :action=>"list"
  end

  def edit
    @expand = Expand.find(params[:id])
  end

  def update
		expand = Expand.find(params[:id])
		expand.update_attributes(params[:expand])
		expand.save
		flash[:notice] = "Expand updated"
		redirect_to :action=>'list'
  end
end
