/* -*- Mode: C; tab-width: 8; indent-tabs-mode: t; c-basic-offset: 8 -*- */
#ifndef __GLADE_UTILS_H__
#define __GLADE_UTILS_H__

#include <glib.h>

G_BEGIN_DECLS


typedef enum _GladeUtilFileDialogType
{
        GLADE_FILE_DIALOG_ACTION_OPEN,
        GLADE_FILE_DIALOG_ACTION_SAVE
} GladeUtilFileDialogType;

typedef enum 
{
	GLADE_UI_INFO,
	GLADE_UI_WARN,
	GLADE_UI_ERROR,
	GLADE_UI_ARE_YOU_SURE,
	GLADE_UI_YES_OR_NO
} GladeUIMessageType;


GType		glade_util_get_type_from_name	(const gchar *name, gboolean have_func);

GParamSpec      *glade_utils_get_pspec_from_funcname (const gchar *funcname);

gboolean         glade_util_ui_message           (GtkWidget *parent, 
						  GladeUIMessageType type,
						  const gchar *format, ...);

void		glade_util_flash_message	(GtkWidget *statusbar, 
						 guint context_id,
						 gchar *format, ...);

/* This is a GCompareFunc for comparing the labels of 2 stock items, ignoring
   any '_' characters. It isn't particularly efficient. */

gint              glade_util_compare_stock_labels (gconstpointer a, gconstpointer b);


void              glade_util_hide_window		(GtkWindow *window);

gchar            *glade_util_gtk_combo_func	(gpointer data);

gpointer          glade_util_gtk_combo_find	(GtkCombo *combo);


GtkWidget        *glade_util_file_dialog_new (const gchar *title,
					      GtkWindow *parent,
					      GladeUtilFileDialogType action);

void              glade_util_replace (gchar *str, gchar a, gchar b);

gchar            *glade_util_read_prop_name (const gchar *str);

gchar            *glade_util_duplicate_underscores (const gchar *name);


void              glade_util_add_selection    (GtkWidget *widget);

void              glade_util_remove_selection (GtkWidget *widget);

gboolean	         glade_util_has_selection    (GtkWidget *widget);

void              glade_util_clear_selection  (void);

GList            *glade_util_get_selection    (void);

void              glade_util_draw_selection_nodes (GdkWindow *expose_win);

GList            *glade_util_container_get_all_children (GtkContainer *container);

gint              glade_util_count_placeholders    (GladeWidget *parent);

GtkTreeIter      *glade_util_find_iter_by_widget   (GtkTreeModel *model,
						    GladeWidget  *findme,
						    gint          column);

gboolean          glade_util_basenames_match       (const gchar  *path1,
						    const gchar  *path2);

GList            *glade_util_purify_list           (GList        *list);

GList            *glade_util_added_in_list         (GList        *old_list,
						    GList        *new_list);

GList            *glade_util_removed_from_list     (GList        *old_list,
						    GList        *new_list);

gchar            *glade_util_canonical_path        (const gchar  *path);


gboolean          glade_util_copy_file             (const gchar  *src_path,
						    const gchar  *dest_path);

gboolean          glade_util_class_implements_interface (GType class_type, 
							 GType iface_type);


GModule          *glade_util_load_library          (const gchar  *library_name);


gboolean          glade_util_file_is_writeable     (const gchar *path);


gboolean          glade_util_have_devhelp          (void);

GtkWidget        *glade_util_get_devhelp_icon      (GtkIconSize size);

void              glade_util_search_devhelp        (const gchar *book,
						    const gchar *page,
						    const gchar *search);

GtkWidget        *glade_util_get_placeholder_from_pointer (GtkContainer *container);


gboolean          glade_util_object_is_loading     (GObject *object);


gboolean          glade_util_url_show              (const gchar *url);


time_t            glade_util_get_file_mtime        (const gchar *filename, GError **error);

G_END_DECLS

#endif /* __GLADE_UTILS_H__ */
