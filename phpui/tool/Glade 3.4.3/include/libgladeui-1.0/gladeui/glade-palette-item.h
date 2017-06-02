/* -*- Mode: C; tab-width: 8; indent-tabs-mode: t; c-basic-offset: 8 -*- */
/*
 * glade-palette-item.h
 *
 * Copyright (C) 2006 Vincent Geddes
 *
 * Authors:
 *   Vincent Geddes <vgeddes@gnome.org>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, 
 * Boston, MA 02111-1307, USA.
 *
 */

#ifndef __GLADE_PALETTE_ITEM_H__
#define __GLADE_PALETTE_ITEM_H__

#include <gladeui/glade.h>
#include <gladeui/glade-palette.h>
#include <gladeui/glade-widget-adaptor.h>

#include <gtk/gtktogglebutton.h>

G_BEGIN_DECLS

#define GLADE_TYPE_PALETTE_ITEM              (glade_palette_item_get_type ())
#define GLADE_PALETTE_ITEM(obj)              (G_TYPE_CHECK_INSTANCE_CAST ((obj), GLADE_TYPE_PALETTE_ITEM, GladePaletteItem))
#define GLADE_PALETTE_ITEM_CLASS(klass)      (G_TYPE_CHECK_CLASS_CAST ((klass), GLADE_TYPE_PALETTE_ITEM, GladePaletteItemClass))
#define GLADE_IS_PALETTE_ITEM(obj)           (G_TYPE_CHECK_INSTANCE_TYPE ((obj), GLADE_TYPE_PALETTE_ITEM))
#define GLADE_IS_PALETTE_ITEM_CLASS(klass)   (G_TYPE_CHECK_CLASS_TYPE ((klass), GLADE_TYPE_PALETTE_ITEM))
#define GLADE_PALETTE_ITEM_GET_CLASS(obj)    (G_TYPE_INSTANCE_GET_CLASS ((obj), GLADE_TYPE_PALETTE_ITEM, GladePaletteItemClass))


typedef struct _GladePaletteItem         GladePaletteItem;
typedef struct _GladePaletteItemPrivate  GladePaletteItemPrivate;
typedef struct _GladePaletteItemClass    GladePaletteItemClass;

struct _GladePaletteItem
{
	GtkToggleButton parent_instance;
	
	GladePaletteItemPrivate *priv;

};

struct _GladePaletteItemClass
{
	GtkToggleButtonClass parent_class;


};

GType                 glade_palette_item_get_type           (void) G_GNUC_CONST;

GtkWidget            *glade_palette_item_new                (GladeWidgetAdaptor *adaptor);

GladeWidgetAdaptor   *glade_palette_item_get_adaptor        (GladePaletteItem *item);

GladeItemAppearance   glade_palette_item_get_appearance     (GladePaletteItem *item);

void		      glade_palette_item_set_appearance     (GladePaletteItem   *item,
							     GladeItemAppearance appearance);

gboolean              glade_palette_item_get_use_small_icon (GladePaletteItem *item);

void		      glade_palette_item_set_use_small_icon (GladePaletteItem *item,
							     gboolean          use_small_icon);


G_END_DECLS

#endif /* __GLADE_PALETTE_ITEM_H__ */
