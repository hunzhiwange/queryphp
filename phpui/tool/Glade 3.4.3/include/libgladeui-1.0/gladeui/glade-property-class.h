/* -*- Mode: C; tab-width: 8; indent-tabs-mode: t; c-basic-offset: 8 -*- */
#ifndef __GLADE_PROPERTY_CLASS_H__
#define __GLADE_PROPERTY_CLASS_H__

#include <glib.h>
#include <glib-object.h>
#include <gtk/gtkadjustment.h>

G_BEGIN_DECLS

/* The GladePropertyClass structure parameters of a GladeProperty.
 * All entries in the GladeEditor are GladeProperties (except signals)
 * All GladeProperties are associated with a GParamSpec.
 */
#define GLADE_PROPERTY_CLASS(gpc)     ((GladePropertyClass *) gpc)
#define GLADE_IS_PROPERTY_CLASS(gpc)  (gpc != NULL)

#define GPC_OBJECT_DELIMITER ", "
#define GPC_PROPERTY_NAMELEN 512  /* Enough space for a property name I think */

typedef struct _GladePropertyClass GladePropertyClass;

/**
 * GPCType:
 * @GPC_NORMAL: is not an atk property
 * @GPC_ATK_PROPERTY: is a property of an #AtkImplementor object
 * @GPC_ATK_RELATION: is an atk relation set property
 * @GPC_ATK_ACTION: is an atk action property
 * @GPC_ACCEL_PROPERTY: is an accelerator key property
 */
typedef enum {
	GPC_NORMAL,
	GPC_ATK_PROPERTY,
	GPC_ATK_RELATION,
	GPC_ATK_ACTION,
	GPC_ACCEL_PROPERTY
} GPCType;

struct _GladePropertyClass
{
	GPCType type; /* A symbolic type used to load/save properties differently
		       */

	gpointer    handle; /* The GladeWidgetClass that this property class
			     * was created for.
			     */

	GParamSpec *pspec; /* The Parameter Specification for this property.
			    */

	gchar *id;       /* The id of the property. Like "label" or "xpad"
			  * this is a non-translatable string
			  */

	gchar *name;     /* The name of the property. Like "Label" or "X Pad"
			  * this is a translatable string
			  */

	gchar *tooltip; /* The default tooltip for the property editor rows.
			 */

	gboolean virt; /* Whether this is a virtual property with its pspec supplied
			* via the catalog (or hard code-paths); or FALSE if its a real
			* GObject introspected property
			*/

	GValue *def;      /* The default value for this property (this will exist
			   * as a copy of orig_def if not specified by the catalog)
			   */

	GValue *orig_def; /* The real default value obtained through introspection.
			   * (used to decide whether we should write to the
			   * glade file or not, or to restore the loaded property
			   * correctly); all property classes have and orig_def.
			   */

	GList *parameters; /* list of GladeParameter objects. This list
			    * provides with an extra set of key-value
			    * pairs to specify aspects of this property.
			    *
			    * This is unused by glade and only maintained
			    * to be of possible use in plugin code.
			    */

	GArray *displayable_values; /* If this property's value is an enumeration/flags and 
				     * there is some value name overridden in a catalog
				     * then it will point to a GEnumValue array with the
				     * modified names, otherwise NULL.
				     */

	gboolean query; /* Whether we should explicitly ask the user about this property
			 * when instantiating a widget with this property (through a popup
			 * dialog).
			 */

	gboolean optional; /* Some properties are optional by nature like
			    * default width. It can be set or not set. A
			    * default property has a check box in the
			    * left that enables/disables the input
			    */

	gboolean optional_default; /* For optional values, what the default is */

	gboolean construct_only; /* Whether this property is G_PARAM_CONSTRUCT_ONLY or not */
	
	gboolean common; /* Common properties go in the common tab */
	gboolean packing; /* Packing properties go in the packing tab */

	
	gboolean translatable; /* The property should be translatable, which
				* means that it needs extra parameters in the
				* UI.
				*/

	gint  visible_lines; /* When this pspec calls for a text editor, how many
			      * lines should be visible in the editor.
			      */

	/* These three are the master switches for the glade-file output,
	 * property editor availability & live object updates in the glade environment.
	 */
	gboolean save;      /* Whether we should save to the glade file or not
			     * (mostly just for custom glade properties)
			     */
	gboolean save_always; /* Used to make a special case exception and always
			       * save this property regardless of what the default
			       * value is (used for some special cases like properties
			       * that are assigned initial values in composite widgets
			       * or derived widget code).
			       */
	gboolean visible;   /* Whether or not to show this property in the editor
			     */
	gboolean ignore;    /* When true, we will not sync the object when the property
			     * changes.
			     */


	gboolean is_modified; /* If true, this property_class has been "modified" from the
			       * the standard property by a xml file. */

	gboolean resource;  /* Some property types; such as some file specifying
			     * string properties or GDK_TYPE_PIXBUF properties; are
			     * resource files and are treated specialy (a filechooser
			     * popup is used and the resource is copied to the project
			     * directory).
			     */

	gboolean themed_icon; /* Some GParamSpecString properties reffer to icon names
			       * in the icon theme... these need to be specified in the
			       * property class definition if proper editing tools are to
			       * be used.
			       */
	
	gboolean transfer_on_paste; /* If this is a packing prop, 
				     * wether we should transfer it on paste.
				     */
	
	gdouble weight;	/* This will determine the position of this property in 
			 * the editor.
			 */
	
};


GladePropertyClass *glade_property_class_new                     (gpointer             handle);

GladePropertyClass *glade_property_class_new_from_spec           (gpointer             handle,
								  GParamSpec          *spec);
 
GList              *glade_property_class_list_atk_relations      (gpointer             handle,
								  GType                owner_type);

GladePropertyClass *glade_property_class_accel_property          (gpointer             handle,
								  GType                owner_type);


GladePropertyClass *glade_property_class_clone                   (GladePropertyClass  *property_class);

void                glade_property_class_free                    (GladePropertyClass  *property_class);

gboolean            glade_property_class_is_visible              (GladePropertyClass  *property_class);

gboolean            glade_property_class_is_object               (GladePropertyClass  *property_class);

GValue             *glade_property_class_make_gvalue_from_string (GladePropertyClass  *property_class,
								  const gchar         *string,
								  GladeProject        *project);

gchar              *glade_property_class_make_string_from_gvalue (GladePropertyClass  *property_class,
								  const GValue        *value);

GValue             *glade_property_class_make_gvalue_from_vl     (GladePropertyClass  *property_class,
								  va_list              vl);

void                glade_property_class_set_vl_from_gvalue      (GladePropertyClass  *klass,
								  GValue              *value,
								  va_list              vl);

GValue             *glade_property_class_make_gvalue             (GladePropertyClass  *klass,
								  ...);

void                glade_property_class_get_from_gvalue         (GladePropertyClass  *klass,
								  GValue              *value,
								  ...);

gboolean            glade_property_class_update_from_node        (GladeXmlNode        *node,
								  GModule             *module,
								  GType                object_type,
								  GladePropertyClass **property_class,
								  const gchar         *domain);

G_CONST_RETURN gchar *glade_property_class_get_displayable_value   (GladePropertyClass *klass, 
								    gint                value);

GtkAdjustment      *glade_property_class_make_adjustment         (GladePropertyClass *property_class);

gboolean            glade_property_class_match                   (GladePropertyClass *klass,
								  GladePropertyClass *comp);

gboolean            glade_property_class_void_value              (GladePropertyClass *klass,
								  GValue             *value);

G_CONST_RETURN gchar *glade_property_class_atk_realname          (const gchar        *atk_name);

G_END_DECLS

#endif /* __GLADE_PROPERTY_CLASS_H__ */
