/* -*- Mode: C; tab-width: 8; indent-tabs-mode: t; c-basic-offset: 8 -*- */
#ifndef __GLADE_CLIPBOARD_VIEW_H__
#define __GLADE_CLIPBOARD_VIEW_H__

#include <gladeui/glade.h>

G_BEGIN_DECLS

#define GLADE_TYPE_CLIPBOARD_VIEW            (glade_clipboard_view_get_type ())
#define GLADE_CLIPBOARD_VIEW(obj)            (G_TYPE_CHECK_INSTANCE_CAST ((obj), GLADE_TYPE_CLIPBOARD_VIEW, GladeClipboardView))
#define GLADE_CLIPBOARD_VIEW_CLASS(klass)    (G_TYPE_CHECK_CLASS_CAST ((klass), GLADE_TYPE_CLIPBOARD_VIEW, GladeClipboardViewClass))
#define GLADE_IS_CLIPBOARD_VIEW(obj)         (G_TYPE_CHECK_INSTANCE_TYPE ((obj), GLADE_TYPE_CLIPBOARD_VIEW))
#define GLADE_IS_CLIPBOARD_VIEW_CLASS(klass) (G_TYPE_CHECK_CLASS_TYPE ((klass), GLADE_TYPE_CLIPBOARD_VIEW))
#define GLADE_CLIPBOARD_VIEW_GET_CLASS(obj)  (G_TYPE_CHECK_CLASS_TYPE ((obj), GLADE_TYPE_CLIPBOARD_VIEW, GladeClipboardViewClass))

typedef struct _GladeClipboardView      GladeClipboardView;
typedef struct _GladeClipboardViewClass GladeClipboardViewClass;

struct _GladeClipboardView
{
	GtkWindow       parent_instance;
	
	GtkWidget      *widget;    /* The GtkTreeView widget */
	GtkListStore   *model;     /* The GtkListStore model for the View */
	GladeClipboard *clipboard; /* The Clipboard for which this is a view */
	gboolean        updating;  /* Prevent feedback from treeview when changing
				    * the selecion. */
};

struct _GladeClipboardViewClass
{
	GtkWindowClass parent_class;
};



GType        glade_clipboard_view_get_type   (void) G_GNUC_CONST;


GtkWidget   *glade_clipboard_view_new (GladeClipboard *clipboard);

void         glade_clipboard_view_add (GladeClipboardView *view,
				       GladeWidget *widget);

void         glade_clipboard_view_remove (GladeClipboardView *view,
					  GladeWidget *widget);

void         glade_clipboard_view_refresh_sel (GladeClipboardView *view);

G_END_DECLS

#endif				/* __GLADE_CLIPBOARD_VIEW_H__ */
