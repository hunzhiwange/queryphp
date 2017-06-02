/* -*- Mode: C; tab-width: 8; indent-tabs-mode: t; c-basic-offset: 8 -*- */
#ifndef __GLADE_GTK_H__
#define __GLADE_GTK_H__

#include <gladeui/glade.h>
#include <gtk/gtk.h>

/* Types */

typedef enum {
	GLADEGTK_IMAGE_FILENAME = 0,
	GLADEGTK_IMAGE_STOCK,
	GLADEGTK_IMAGE_ICONTHEME
} GladeGtkImageType;

typedef enum {
	GLADEGTK_BUTTON_LABEL = 0,
	GLADEGTK_BUTTON_STOCK,
	GLADEGTK_BUTTON_CONTAINER
} GladeGtkButtonType;

GType       glade_gtk_image_type_get_type  (void);
GType       glade_gtk_button_type_get_type (void);

GParamSpec *glade_gtk_gnome_ui_info_spec   (void);

GParamSpec *glade_gtk_image_type_spec      (void);

GParamSpec *glade_gtk_button_type_spec     (void);

			 		    
#endif /* __GLADE_GTK_H__ */
