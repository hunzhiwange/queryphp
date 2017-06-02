/* -*- Mode: C; c-basic-offset: 4 -*-
 * libglade - a library for building interfaces from XML files at runtime
 * Copyright (C) 1998-2002  James Henstridge <james@daa.com.au>
 *
 * glade-parser.h: functions for parsing glade-2.0 files
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Library General Public
 * License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Library General Public License for more details.
 *
 * You should have received a copy of the GNU Library General Public
 * License along with this library; if not, write to the 
 * Free Software Foundation, Inc., 59 Temple Place - Suite 330,
 * Boston, MA  02111-1307, USA.
 */

#ifndef __GLADE_PARSER_H__
#define __GLADE_PARSER_H__

#include <glib.h>
#include <gdk/gdk.h>

G_BEGIN_DECLS

#define CAST_BAD (gchar *)

typedef struct _GladePropInfo        GladePropInfo;
typedef struct _GladeSignalInfo      GladeSignalInfo;
typedef struct _GladeAtkActionInfo   GladeAtkActionInfo;
typedef struct _GladeAccelInfo       GladeAccelInfo;
typedef struct _GladeWidgetInfo      GladeWidgetInfo;
typedef struct _GladeChildInfo       GladeChildInfo;
typedef struct _GladeInterface       GladeInterface;
typedef struct _GladeAtkRelationInfo GladeAtkRelationInfo;
typedef struct _GladePackingDefault  GladePackingDefault;

struct _GladePropInfo {
    gchar *name;
    gchar *value;
    gchar *comment;
    guint  translatable : 1;
    guint  has_context : 1;
};

struct _GladeSignalInfo {
    gchar *name;
    gchar *handler;
    gchar *object; /* represents userdata, if lookup is FALSE, then do connect_object with a
                    * widget looked up by name, otherwise g_module_lookup() */
    guint after : 1;
    guint lookup : 1;
};

struct _GladePackingDefault {
    gchar  *id;
    gchar  *value;
};

struct _GladeAtkActionInfo {
    gchar *action_name;
    gchar *description;
};

struct _GladeAtkRelationInfo {
    gchar *target;
    gchar *type;
};

struct _GladeAccelInfo {
    guint key;
    GdkModifierType modifiers;
    gchar *signal;
};

struct _GladeWidgetInfo {
    GladeWidgetInfo *parent;

    gchar *classname;
    gchar *name;

    GladePropInfo *properties;
    guint n_properties;

    GladePropInfo *atk_props;
    guint n_atk_props;

    GladeSignalInfo *signals;
    guint n_signals;
	
    GladeAtkActionInfo *atk_actions;
    guint n_atk_actions;

    GladeAtkRelationInfo *relations;
    guint n_relations;

    GladeAccelInfo *accels;
    guint n_accels;

    GladeChildInfo *children;
    guint n_children;
};

struct _GladeChildInfo {
    GladePropInfo *properties;
    guint n_properties;

    GladeWidgetInfo *child;
    gchar *internal_child;
};

struct _GladeInterface {
    gchar **requires;
    guint n_requires;

    GladeWidgetInfo **toplevels;
    guint n_toplevels;

    GHashTable *names;

    GHashTable *strings;

    gchar *comment;
};

/* the actual functions ... */
GladeInterface *glade_parser_interface_new (void);

GladeInterface *glade_parser_interface_new_from_file (const gchar *file,
						      const gchar *domain);

GladeInterface *glade_parser_interface_new_from_buffer (const gchar *buffer,
							gint len,
							const gchar *domain);

void            glade_parser_interface_destroy   (GladeInterface  *interface);

gboolean        glade_parser_interface_dump (GladeInterface  *interface, 
					     const gchar     *filename,
					     GError         **error);

G_CONST_RETURN gchar *glade_parser_pvalue_from_winfo (GladeWidgetInfo *winfo,
						      const gchar     *pname);

G_END_DECLS

#endif
