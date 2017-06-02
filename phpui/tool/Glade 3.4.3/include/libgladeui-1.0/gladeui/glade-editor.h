/* -*- Mode: C; tab-width: 8; indent-tabs-mode: t; c-basic-offset: 8 -*- */
#ifndef __GLADE_EDITOR_H__
#define __GLADE_EDITOR_H__

#include <gladeui/glade-signal-editor.h>

G_BEGIN_DECLS


#define GLADE_TYPE_EDITOR            (glade_editor_get_type ())
#define GLADE_EDITOR(obj)            (G_TYPE_CHECK_INSTANCE_CAST ((obj), GLADE_TYPE_EDITOR, GladeEditor))
#define GLADE_EDITOR_CLASS(klass)    (G_TYPE_CHECK_CLASS_CAST ((klass), GLADE_TYPE_EDITOR, GladeEditorClass))
#define GLADE_IS_EDITOR(obj)         (G_TYPE_CHECK_INSTANCE_TYPE ((obj), GLADE_TYPE_EDITOR))
#define GLADE_IS_EDITOR_CLASS(klass) (G_TYPE_CHECK_CLASS_TYPE ((klass), GLADE_TYPE_EDITOR))
#define GLADE_EDITOR_GET_CLASS(obj)  (G_TYPE_INSTANCE_GET_CLASS ((obj), GLADE_TYPE_EDITOR, GladeEditorClass))

#define GLADE_EDITOR_TABLE(t)       ((GladeEditorTable *)t)
#define GLADE_IS_EDITOR_TABLE(t)    (t != NULL)

typedef struct _GladeEditor          GladeEditor;
typedef struct _GladeEditorClass     GladeEditorClass;
typedef struct _GladeEditorTable     GladeEditorTable;

typedef enum _GladeEditorTableType
{
	TABLE_TYPE_GENERAL,
	TABLE_TYPE_COMMON,
	TABLE_TYPE_PACKING,
	TABLE_TYPE_ATK,
	TABLE_TYPE_QUERY
} GladeEditorTableType;

/* The GladeEditor is a window that is used to display and modify widget
 * properties. The glade editor contains the details of the selected
 * widget for the selected project
 */
struct _GladeEditor
{
	GtkVBox vbox;  /* The editor is a vbox */
	
	GtkWidget *notebook; /* The notebook widget */

	GladeWidget *loaded_widget; /* A handy pointer to the GladeWidget
				     * that is loaded in the editor. NULL
				     * if no widgets are selected
				     */

	GladeWidgetAdaptor *loaded_adaptor; /* A pointer to the loaded
					     * GladeWidgetAdaptor. Note that we can
					     * have a class loaded without a
					     * loaded_widget. For this reason we
					     * can't use loaded_widget->adaptor.
					     * When a widget is selected we load
					     * this class in the editor first and
					     * then fill the values of the inputs
					     * with the GladeProperty items.
					     * This is usefull for not having
					     * to redraw/container_add the widgets
					     * when we switch from widgets of the
					     * same class
					     */


	/* The editor has (at this moment) four tabs; these are pointers to the 
	 * widget inside each tab. The widgets are wrapped into a scrolled window.
	 * The page_* widgets are deparented and parented with
	 * ((GladeEditorTable *)etable)->table_widget when a widget is selected and
	 * the correct editor table is found. The exception is `page_signals' which
	 * always contains the same signal editor widget which simply reloads when
	 * loading a widget.
	 */
	GtkWidget *page_widget;
	GtkWidget *page_packing;
	GtkWidget *page_common;
	GtkWidget *page_signals;
	GtkWidget *page_atk;

	GladeSignalEditor *signal_editor; /* The signal editor packed into vbox_signals
					   */

	GList *widget_tables; /* A list of GladeEditorTable. We have a table
				* (gtktable) for each GladeWidgetClass, if
				* we don't have one yet, we create it when
				* we are asked to load a widget of a particular
				* GladeWidgetClass
				*/
				
	GladeEditorTable *packing_etable; /* Packing pages are dynamicly created each
					   * selection, this pointer is only to free
					   * the last packing page.
					   */
	 
	GList            *packing_eprops; /* Current list of packing GladeEditorProperties
					   */

	gboolean loading; /* Use when loading a GladeWidget into the editor
			   * we set this flag so that we can ignore the
			   * "changed" signal of the name entry text since
			   * the name has not really changed, just a new name
			   * was loaded.
			   */

	gulong project_closed_signal_id; /* Unload widget when widget's project closes.
					  */
	
	GtkWidget *reset_button; /* The reset button
				  */
	
	GtkWidget *info_button; /* The actual informational button
				 */

	gboolean show_info; /* Whether or not to show an informational button
			     */
	gboolean show_context_info; /* Whether or not to show an informational
				     * button for each property and signal.
				     */
};

struct _GladeEditorClass
{
	GtkVBoxClass parent_class;

	void   (*add_signal) (GladeEditor *editor, const char *id_widget,
			      GType type_widget, guint id_signal,
			      const char *callback_name);

	void   (*gtk_doc_search) (GladeEditor *,
				  const gchar *,
				  const gchar *,
				  const gchar *);

};

/* For each glade widget class that we have modified, we create a
 * GladeEditorTable. A GladeEditorTable is mainly a gtk_table with all the
 * widgets to edit a particular GladeWidgetClass (well the first tab of the
 * gtk notebook). When a widget of is selected
 * and going to be edited, we create a GladeEditorTable, when another widget
 * of the same class is loaded so that it can be edited, we just update the
 * contents of the editor table to relfect the values of that GladeWidget
 */
struct _GladeEditorTable
{
	GladeEditor *editor; /* Handy pointer that avoids havving to pass the
			      * editor arround.
			      */
	
	GladeWidgetAdaptor *adaptor; /* The GladeWidgetAdaptor this
				      * table belongs to.
				      */

	GtkWidget *table_widget; /* This widget is a gtk_vbox that is displayed
				  * in the glade-editor when a widget of this
				  * class is selected. It is hiden when another
				  * type is selected. When we select a widget
				  * we load into the inputs inside this table
				  * the information about the selected widget.
				  */
	
	GtkWidget *name_entry; /* A pointer to the gtk_entry that holds
				* the name of the widget. This is the
				* first item _pack'ed to the table_widget.
				* We have a pointer here because it is an
				* entry which will not be created from a
				* GladeProperty but rather from code.
				*/

	GList *properties; /* A list of GladeEditorPropery items.
			    * For each row in the gtk_table, there is a
			    * corrsponding GladeEditorProperty struct.
			    */

	GladeEditorTableType type; /* Is this table to be used in the common tab, ?
				    * the general tab, a packing tab or the query popup ?
				    */

	gint  rows;
};


GType        glade_editor_get_type           (void);

GladeEditor *glade_editor_new                (void);

void         glade_editor_load_widget        (GladeEditor *editor,
					      GladeWidget *widget);

void         glade_editor_refresh            (GladeEditor *editor);

void         glade_editor_update_widget_name (GladeEditor *editor);

gboolean     glade_editor_query_dialog       (GladeEditor *editor,
					      GladeWidget *widget);

void         glade_editor_show_info          (GladeEditor *editor);

void         glade_editor_show_context_info  (GladeEditor *editor);

void         glade_editor_hide_info          (GladeEditor *editor);

void         glade_editor_hide_context_info  (GladeEditor *editor);



G_END_DECLS

#endif /* __GLADE_EDITOR_H__ */
